<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<div class="default_contents">
<!-- 회원가입약관 동의 시작 { -->
<div id="mb_join" class="mbskin">
    <h1>VOGOS Sign Up</h1>
    <form  name="fregister" id="fregister" action="<?php echo $register_action_url ?>" onsubmit="return fregister_submit(this);" method="POST" autocomplete="off">

    <section id="fregister_term">
        <h2>Terms and Conditions</h2>
        <fieldset class="fregister_agree">
            <input type="checkbox" name="agree" value="1" id="agree11">
            <label for="agree11">I agree to your Terms and Conditions (*Required)</label>
        </fieldset>
        <textarea readonly><?php echo get_text($config['cf_stipulation']) ?></textarea>
    </section>

    <section id="fregister_private">
        <h2>Privacy Policy</h2>
        <fieldset class="fregister_agree">
            <input type="checkbox" name="agree2" value="1" id="agree21">
            <label for="agree21">I agree to your Privacy Policy (*Required)</label>
        </fieldset>
        <textarea readonly><?php echo get_text($config['cf_privacy']) ?></textarea>
    </section>

    <div class="btn_confirm">
        <p>Please agree to our Term and Conditions to complete sign up process.</p>
        <input type="submit" class="btn_submit" value="Sign Up">
    </div>

    </form>

    <script>
    function fregister_submit(f)
    {
        if (!f.agree.checked) {
            alert("Please agree to our Term and Conditions to complete sign up process.");
            f.agree.focus();
            return false;
        }

        if (!f.agree2.checked) {
            alert("Please agree to our Privacy Policy to enable sign in.");
            f.agree2.focus();
            return false;
        }

        return true;
    }
    </script>
</div>
<!-- } 회원가입 약관 동의 끝 -->
</div>