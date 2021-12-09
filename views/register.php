<h1>Register</h1>

<?php
    use app\core\form\Form;
    use app\core\form\Field;

    $form = Form::begin('', 'post');
?>
<div class="row">
    <div class="col">
        <?= $form->field($model, 'first_name') ?>
    </div>
    <div class="col">
        <?= $form->field($model, 'last_name') ?>
    </div>
</div>
<?= $form->field($model, 'email', Field::TYPE_EMAIL) ?>
<?= $form->field($model, 'password', Field::TYPE_PASSWORD) ?>
<?= $form->field($model, 'confirm_password', Field::TYPE_PASSWORD) ?>
<button type="submit" class="btn btn-primary">Submit</button>
<?php Form::end() ?>