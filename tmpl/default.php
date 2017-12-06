<?php

defined('_JEXEC') or die; ?>

<form action="" method="POST" id="feedback" class="form-horizontal">
    <div class="userdata">
        <div class="control-group">
            <div class="control-label">
                <label class="required" for="feedback-name">
                Ваше ім'я <span class="star">*</span>
                </label>
            </div>
            <div class="controls">
                <input class="required" id="feedback-name" type="text" name="fname" placeholder="Ваше ім'я">
                <div class="feedback-error"></div>
            </div>
        </div>
        <div class="control-group">
            <div class="control-label">
                <label class="required" for="feedback-phone">
                Ваш телефон <span class="star">*</span>
                </label>
            </div>
            <div class="controls">
                <input class="required" id="feedback-phone" type="text" name="fphone" placeholder="Ваш телефон">
                <div class="feedback-error"></div>
            </div>
        </div>
        <div class="control-group">
            <div class="control-label">
                <label for="feedback-email">E-mail <span class="star"></span></label>
            </div>
            <div class="controls">
                <input class="required" id="feedback-email" type="email" name="femail" placeholder="E-mail">
                <div class="feedback-error"></div>
            </div>
        </div>
        <div class="control-group">
            <div class="control-label">
                <label class="required" for="feedback-text">Будь ласка, вкажить бажану процедуру або причину Вашого візиту <span class="star">*</span></label>
            </div>
            <div class="controls">
                <textarea class="required" id="feedback-text" name="ftext" cols="30" rows="8"></textarea>
                <div class="feedback-error"></div>
            </div>
        </div>
            <div class="controls">
            <button name="submit" value="1" class="btn btn-primary">Надіслати</button>
            </div>
    </div>
</form>
