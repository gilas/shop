<?php
$this->Html->addCrumb('ثبت نام یا ورود کاربر');
?>

<fieldset>
    <legend>ورود</legend>
    <form class="form-inline" method="post" action="<?php echo $this->Html->url(array('login')) ?>">
        <div class="row">
            <div class="span3">
                <label>نام کاربری</label>
                <input type="text" name="data[username]" />
            </div>
            <div class="span3">
                <label>رمز عبور</label>
                <input type="password" name="data[password]" />
            </div>
            <div>
                <input type="submit" value="ورود"  />
            </div>
        </div>
    </form>
</fieldset>

<fieldset>
    <legend>ثبت نام</legend>
    <form class="form-horizontal" method="post" action="<?php echo $this->Html->url(array('register')) ?>">
        <div class="row row-pad">
            <div class="span8">
                <label>نام و نام خانوادگی</label>
                <input type="text" name="data[name]" />
            </div>
        </div>
        <div class="row row-pad">
            <div class="span8">
                <label>شماره تلفن</label>
                <input type="text" name="data[phone]" />
            </div>
        </div>
        <div class="row row-pad">
            <div class="span8">
                <label>شماره همراه</label>
                <input type="text" name="data[mobile]" />
            </div>
        </div>
        <div class="row row-pad">
            <div class="span8">
                <label>آدرس دقیق پستی</label>
                <input type="text" name="data[address]" />
            </div>
        </div>
        <div class="row row-pad">
            <div class="span8">
                <label>نام کاربری</label>
                <input type="text" name="data[username]" />
            </div>
        </div>
        <div class="row row-pad">
            <div class="span8">
                <label>رمز عبور</label>
                <input type="password" name="data[password]" />
            </div>
        </div>
        <div class="row row-pad">
            <div class="span8">
                <label>تکرار رمز عبور</label>
                <input type="password" name="data[password2]" />
            </div>
        </div>
            <div>
                <input type="submit" value="ورود"  />
            </div>
        </div>
    </form>
</fieldset>