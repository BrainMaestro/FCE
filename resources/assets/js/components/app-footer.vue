<template>
    <footer class="footer">
        <div class="container">
            <div class="content has-text-centered">
                <img src="/images/aun_logo.png" alt="AUN Logo" height="40"><hr>
                <p>
                    The source code is licensed
                    <a href="http://creativecommons.org/licenses/by-nc-nd/3.0/">CC BY-NC-ND 3.0</a>.<br>
                    And can be found at
                    <a class="icon" href="https://github.com/BrainMaestro/FCE">
                        <i class="fa fa-github"></i>
                    </a>
                </p>
                <p>Take a look at the code. You might learn something or better yet, teach us something new.</p>
                <img src="/images/cool-face.svg" alt="Happy Face" height="30" width="30">
            </div>
        </div>
    </footer>
</template>

<style>
    .footer {
        background: #333275;
        color: white;
        padding-bottom: 2em;
    }

    .footer a {
        color: forestgreen;
        text-decoration: none;
    }

    .footer a:hover {
        color: indianred;
    }

    .footer a:not(.icon) {
        border-bottom: 1px solid forestgreen;
    }

    .footer a:not(.icon):hover {
        border-bottom: 1px solid indianred;
    }
</style>
