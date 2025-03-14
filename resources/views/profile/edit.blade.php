<x-app-layout>

    <div class="container mb-5">

        <x-caption sub="Ваш личный профиль">{{ __('Profile') }}</x-caption>




        <div class="row">
            <div class="col-xl-3 col-md-12">


                <div class="nav nav-pills me-3" role="tablist" aria-orientation="vertical">

                    <button class="nav-link active" id="tab-profile-tab" data-bs-toggle="pill"
                        data-bs-target="#tab-profile" type="button" role="tab" aria-controls="tab-profile"
                        aria-selected="true">Профиль</button>

                    <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill"
                        data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile"
                        aria-selected="false">История бронирования</button>
{{--
                    <button class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill"
                        data-bs-target="#v-pills-messages" type="button" role="tab"
                        aria-controls="v-pills-messages" aria-selected="false">История предзаказов</button> --}}

                    <button class="nav-link" id="tab-settings-tab" data-bs-toggle="pill" data-bs-target="#tab-settings"
                        type="button" role="tab" aria-controls="tab-settings"
                        aria-selected="false">Настройки</button>
                </div>


            </div>

            <div class="col-xl-9 col-md-12">
                <div class="bg-body-secondary rounded overflow-hidden mb-4 p-4">

                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="tab-profile" role="tabpanel"
                            aria-labelledby="tab-profile-tab">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                        <div class="tab-pane fade" id="v-pills-profile" role="tabpanel"
                            aria-labelledby="v-pills-profile-tab">...</div>
                        <div class="tab-pane fade" id="v-pills-messages" role="tabpanel"
                            aria-labelledby="v-pills-messages-tab">...</div>
                        <div class="tab-pane fade" id="tab-settings" role="tabpanel" aria-labelledby="tab-settings-tab">
                            @include('profile.partials.update-password-form')</div>
                    </div>



                    {{-- @include('profile.partials.delete-user-form') --}}
                </div>
            </div>
        </div>


        {{-- <div class="col-xl-8 col-md-12 mx-auto">
            <div class="bg-body-tertiary rounded overflow-hidden mb-4">
                <!-- Cover image -->
                <div class="rounded-top profile-cover"></div>
                <!-- Card body START -->
                <div class="px-5">
                    <div class="d-sm-flex align-items-start">
                        <div>
                            <!-- Avatar -->
                            <div class="avatar avatar-xxl mt-n5 mb-3 mx-auto mx-lg-0">
                                <img class="avatar-img rounded border border-tertiary-subtle border-3"
                                    src="https://avatars.githubusercontent.com/u/5220449?v=4" alt="">
                            </div>

                            <p class="small opacity-50 text-balance">Ваш аватар автоматически загружается при входе в
                                профиль из
                                вашего аккаунта на <a href="https://github.com" target="_blank">GitHub</a>.
                            </p>
                        </div>
                        <div class="ms-sm-4 mt-sm-4 flex-grow-1">
                            <form action="https://laravel.su/profile/update" method="post">


                                <div class="mb-4">
                                    <label for="name" class="form-label">Имя</label>
                                    <input class="form-control" placeholder="Как вас зовут?" required=""
                                        type="text" value="Ard2p" maxlength="100" id="name" name="name">
                                    <div class="form-text mt-2">Использование настоящего имени помогает установить
                                        личное
                                        взаимодействие и создать доверительную обстановку в
                                        профессиональной среде.
                                    </div>
                                </div>


                                <div class="mb-4">
                                    <label for="name" class="form-label">Достижение</label>



                                    <select class="form-control" id="selected_achievement" name="selected_achievement">
                                        <option value="">Выберите достижение</option>

                                    </select>

                                    <div class="form-text mt-2">
                                        Позволит вам выделяться среди других пользователей и подчеркнет вашу
                                        <a href="https://laravel.su/achievements">активность и значимость</a> в
                                        сообществе.
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="about" class="form-label ">О себе</label>
                                    <textarea data-controller="textarea-autogrow" data-textarea-autogrow-resize-debounce-delay-value="500" rows="6"
                                        maxlength="280" id="about" name="about" placeholder="Над чем вы работаете?" class="form-control"
                                        style="overflow: hidden; height: 160px;"></textarea>

                                    <div class="form-text mt-2">
                                        Расскажите немного о себе, своем опыте работы.
                                        Будет замечательно, если вы поделитесь своими проектами или достижениями,
                                        связанными
                                        с разработкой на Laravel.
                                    </div>
                                </div>

                                <div class="mb-4 d-block d-md-none">
                                    <label for="theme-checker-auto" class="form-label d-block">Оформление</label>

                                    <div data-controller="theme" data-action="change->theme#toggleTheme"
                                        data-turbo-permanent="" class="btn-group mb-3" role="group"
                                        aria-label="Тема оформления" id="theme-checker-group-user-settings">
                                        <input type="radio" value="auto" data-theme-target="preferred"
                                            class="btn-check" name="theme-checker" id="theme-checker-auto"
                                            autocomplete="off" checked="">
                                        <label class="btn btn-outline-secondary d-inline-flex align-items-center py-2"
                                            for="theme-checker-auto">


                                        </label>

                                        <input type="radio" value="light" data-theme-target="preferred"
                                            class="btn-check" name="theme-checker" id="theme-checker-light"
                                            autocomplete="off">
                                        <label class="btn btn-outline-secondary d-inline-flex align-items-center"
                                            for="theme-checker-light">


                                        </label>

                                        <input type="radio" value="dark" data-theme-target="preferred"
                                            class="btn-check" name="theme-checker" id="theme-checker-dark"
                                            autocomplete="off" checked="true">
                                        <label class="btn btn-outline-secondary d-inline-flex align-items-center"
                                            for="theme-checker-dark">
                                            <svg xmlns="http://www.w3.org/2000/svg" color="currentColor"
                                                viewBox="0 0 20 20" class="my-1" width="1rem" height="1rem"
                                                role="img" fill="currentColor" path="i.theme-dark"
                                                componentname="icon">
                                                <path
                                                    d="m10,19c-4.96,0-9-4.04-9-9S5.04,1,10,1c1.51,0,3.01.38,4.33,1.11.43.24.63.75.46,1.22-.17.46-.64.74-1.13.64-2.75-.53-5.14,1.6-5.14,4.25,0,2.39,1.94,4.33,4.33,4.33,1.94,0,3.65-1.31,4.17-3.18.13-.47.59-.77,1.08-.73.49.06.86.46.89.95v.11c.01.1.02.2.02.29,0,4.96-4.04,9-9,9Zm-.8-15.96c-3.49.4-6.2,3.37-6.2,6.96,0,3.86,3.14,7,7,7,2.47,0,4.65-1.29,5.9-3.23-.91.51-1.96.79-3.05.79-3.49,0-6.33-2.84-6.33-6.33,0-2.14,1.06-4.03,2.69-5.18Z">
                                                </path>
                                            </svg>

                                        </label>
                                    </div>

                                    <div class="form-text">
                                        Выберите тему, которая наиболее подходит вашим предпочтениям, или настройте
                                        автоматическое переключение между дневной и ночной темами, чтобы интерфейс
                                        адаптировался автоматически в соответствии с вашей системой.
                                    </div>
                                </div>
                                <div class="mb-4" data-controller="webpush"
                                    data-webpush-error-supported-value="Push-сообщения не поддерживаются на этом устройстве"
                                    data-webpush-error-permission-value="Доступ запрещён">
                                    <label class="form-label d-block">Push-уведомления</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input me-3" type="checkbox"
                                            data-action="change->webpush#switching" data-webpush-target="status"
                                            role="switch" value="0" id="native_notifiable"
                                            name="native_notifiable" checked="">
                                        <label for="native_notifiable" class="form-check-label small">Включить на этом
                                            устройстве</label>

                                    </div>

                                    <div class="form-text">
                                        Для уведомлений на мобильных телефонах установите сайт, как PWA, после этого вы
                                        будете получать уведомления вне сайта.
                                    </div>
                                </div>
                                <div class="d-flex d-md-inline-block">
                                    <button type="submit" class="btn btn-primary mb-3 w-100">Сохранить</button>
                                </div>


                            </form>
                        </div>


                    </div>

                </div>
            </div>
        </div> --}}

    </div>
</x-app-layout>
