<template>
    <div class="container--signin">
        <div class="form--signin">
            <div class="form__title">
                <h2>
                    <img src="image/logo_32.svg" width="48" height="48" alt="petata">
                    Sign in
                </h2>
            </div>
            <div class="form__wrapper--signin">
                <label class="form__label">Email
                    <span class="form__error-message">メールアドレスの形式が正しくありません。</span>
                </label>
                <input type="text" class="form__text" placeholder="taro-2525@petata.com">
                <label class="form__label">Password</label>
                <input type="password" class="form__text">
                <span class="form__checkbox">
                  <label for="chkRemember">
                    <input id="chkRemember" type="checkbox">Remember me
                  </label>
                  <a href="#" class="form__link--right">Forget password</a>
                </span>
                <button type="button" class="form__button--submit">Sign in</button>
            </div>
            <div class="form__social-signin">
                <img src="image/btn_google_signin_dark_normal_web@2x.png" alt="g-login">
            </div>
            <a href="#" class="form__link">Sign up</a>
        </div>
    </div><!-- /.container -->
</template>