<?php
/** @var $model \thecodeholic\phpmvc\Model */

use thecodeholic\phpmvc\form\Form;

$form = new Form();
$this->title = 'Buyer';

?>

<h1>Buyer Input</h1>

<?php $form = Form::begin('/buyer', 'post') ?>
    <?php echo $form->field($model, 'amount') ?>
    <?php echo $form->field($model, 'buyer') ?>
    <?php echo $form->field($model, 'receipt_id') ?>
    <?php echo $form->field($model, 'items') ?>
    <?php echo $form->field($model, 'buyer_email') ?>
    <?php echo $form->field($model, 'note') ?>
    <?php echo $form->field($model, 'city') ?>
    <?php echo $form->field($model, 'phone') ?>
    <?php // echo $form->field($model, 'hash_key') ?>
    <?php // echo $form->field($model, 'entry_at') ?>
    
    <!-- <div class="form-group">
        <label>entry_at</label>
        <input type="date" class="form-control is-invalid" name="entry_at" value="asd">
        <div class="invalid-feedback">
            This field have to be date
        </div>
    </div> -->
    <button class="btn btn-success">Submit</button>
<?php Form::end() ?>