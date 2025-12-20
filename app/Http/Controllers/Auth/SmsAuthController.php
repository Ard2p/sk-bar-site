<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\SMSService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class SmsAuthController extends Controller
{
    protected $smsService;

    public function __construct(SMSService $smsService)
    {
        $this->smsService = $smsService;
    }

    /**
     * Show SMS registration form
     */
    public function showRegister(): View
    {
        return view('auth.sms-register');
    }

    /**
     * Send SMS code for registration
     */
    public function sendSmsCode(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'regex:/^\+?[0-9]{10,15}$/', 'unique:users,phone'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $phone = $this->normalizePhone($request->phone);
        $smsCode = $this->generateSmsCode();

        try {
            $this->smsService->send([
                [
                    'phone' => $phone,
                    'text' => "Ваш код подтверждения: {$smsCode}",
                    'sender' => 'SKBar'
                ]
            ]);

            // Сохраняем данные в сессии
            session([
                'registration_data' => [
                    'name' => $request->name,
                    'phone' => $phone,
                    'sms_code' => $smsCode,
                    'sms_code_expires_at' => now()->addMinutes(5)
                ]
            ]);

            return redirect()->route('auth.verify-sms')->with('success', 'Код отправлен на ваш номер телефона');
        } catch (\Exception $e) {
            return back()->withErrors(['phone' => 'Ошибка отправки SMS. Попробуйте позже.'])->withInput();
        }
    }

    /**
     * Show SMS verification form
     */
    public function showVerifySms(): View|RedirectResponse
    {
        if (!session('registration_data')) {
            return redirect()->route('auth.sms-register');
        }

        return view('auth.verify-sms');
    }

    /**
     * Verify SMS code and complete registration
     */
    public function verifySmsCode(Request $request): RedirectResponse
    {
        $registrationData = session('registration_data');

        if (!$registrationData) {
            return redirect()->route('auth.sms-register');
        }

        $validator = Validator::make($request->all(), [
            'sms_code' => ['required', 'string', 'size:4'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        if ($registrationData['sms_code'] !== $request->sms_code) {
            return back()->withErrors(['sms_code' => 'Неверный код подтверждения']);
        }

        if (now()->isAfter($registrationData['sms_code_expires_at'])) {
            return back()->withErrors(['sms_code' => 'Код подтверждения истек']);
        }

        // Создаем пользователя
        $user = User::create([
            'name' => $registrationData['name'],
            'phone' => $registrationData['phone'],
            'phone_verified_at' => now(),
            'password' => Hash::make('default_password_' . time()), // Временный пароль
        ]);

        // Авторизуем пользователя
        Auth::login($user);

        // Очищаем сессию
        session()->forget('registration_data');

        return redirect()->route('profile.dashboard')->with('success', 'Регистрация успешно завершена!');
    }

    /**
     * Show SMS login form
     */
    public function showLogin(): View
    {
        return view('auth.sms-login');
    }

    /**
     * Send SMS code for login
     */
    public function sendLoginSms(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'phone' => ['required', 'string', 'regex:/^\+?[0-9]{10,15}$/'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $phone = $this->normalizePhone($request->phone);
        $user = User::where('phone', $phone)->first();

        if (!$user) {
            return back()->withErrors(['phone' => 'Пользователь с таким номером не найден']);
        }

        $smsCode = $this->generateSmsCode();

        try {
            $this->smsService->send([
                [
                    'phone' => $phone,
                    'text' => "Ваш код для входа: {$smsCode}",
                    'sender' => 'SKBar'
                ]
            ]);

            // Обновляем SMS код в базе данных
            $user->update([
                'sms_code' => $smsCode,
                'sms_code_expires_at' => now()->addMinutes(5)
            ]);

            return redirect()->route('auth.verify-login-sms')->with('success', 'Код отправлен на ваш номер телефона');
        } catch (\Exception $e) {
            return back()->withErrors(['phone' => 'Ошибка отправки SMS. Попробуйте позже.'])->withInput();
        }
    }

    /**
     * Show SMS verification form for login
     */
    public function showVerifyLoginSms(): View
    {
        return view('auth.verify-login-sms');
    }

    /**
     * Verify SMS code and login
     */
    public function verifyLoginSms(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'phone' => ['required', 'string'],
            'sms_code' => ['required', 'string', 'size:4'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $phone = $this->normalizePhone($request->phone);
        $user = User::where('phone', $phone)->first();

        if (!$user || !$user->isSmsCodeValid($request->sms_code)) {
            return back()->withErrors(['sms_code' => 'Неверный код подтверждения']);
        }

        // Авторизуем пользователя
        Auth::login($user);

        // Очищаем SMS код
        $user->update([
            'sms_code' => null,
            'sms_code_expires_at' => null
        ]);

        return redirect()->route('profile.dashboard')->with('success', 'Добро пожаловать!');
    }

    /**
     * Generate 4-digit SMS code
     */
    private function generateSmsCode(): string
    {
        return str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    }

    /**
     * Normalize phone number
     */
    private function normalizePhone(string $phone): string
    {
        // Убираем все символы кроме цифр
        $phone = preg_replace('/[^0-9]/', '', $phone);

        // Если номер начинается с 8, заменяем на 7
        if (substr($phone, 0, 1) === '8') {
            $phone = '7' . substr($phone, 1);
        }

        // Если номер не начинается с 7, добавляем 7
        if (substr($phone, 0, 1) !== '7') {
            $phone = '7' . $phone;
        }

        return $phone;
    }
}
