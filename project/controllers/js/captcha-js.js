(function () {
    const fonts = ["cursive", "sans-serif", "serif", "monospace"];
    let captchaValue = "";

    function generateCaptcha() {
        const chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        let value = "";
        for (let i = 0; i < 6; i++) {
            value += chars[Math.floor(Math.random() * chars.length)];
        }
        captchaValue = value;
    }

    function setCaptcha() {
        const preview = document.querySelector(".captcha .preview");
        const html = captchaValue
            .split("")
            .map((char) => {
                const rotate = -20 + Math.trunc(Math.random() * 40);
                const font = Math.trunc(Math.random() * fonts.length);
                return `<span style="transform: rotate(${rotate}deg); font-family: ${fonts[font]};">${char}</span>`;
            })
            .join("");
        preview.innerHTML = html;
    }

    function initCaptcha() {
        document
            .querySelector(".captcha .captcha-refresh")
            .addEventListener("click", function () {
                generateCaptcha();
                setCaptcha();
            });
        generateCaptcha();
        setCaptcha();
    }

    function validateCaptcha() {
        const inputCaptcha = document.getElementById("captcha-input").value;
        return inputCaptcha === captchaValue;
    }

    // Initialize CAPTCHA
    initCaptcha();

    // Example validation (adjust as needed for your project)
    document.getElementById("login-btn").addEventListener("click", function (e) {
        e.preventDefault();
        if (validateCaptcha()) {
            alert("CAPTCHA validated successfully!");
        } else {
            alert("Incorrect CAPTCHA. Please try again.");
        }
    });
})();
