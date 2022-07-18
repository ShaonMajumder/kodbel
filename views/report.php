
<?php
/** @var $model \thecodeholic\phpmvc\Model */

use thecodeholic\phpmvc\form\Form;

$form = new Form();
$this->title = 'Report';
?>

<script>
    $(function() {
        $('input[name="daterange"]').daterangepicker({
            locale: {
                format: 'YYYY-MM-DD'
            },
            opens: 'left'
        }, function(start, end, label) {
            console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
        });
    });
</script>



<h1>Report</h1>

<div class="">

<?php $form = Form::begin('/report', 'post') ?>
    <?php // echo $form->field($model, 'amount') ?>
    <?php // echo $form->field($model, 'buyer') ?>
    <?php // echo $form->field($model, 'receipt_id') ?>
    <?php // echo $form->field($model, 'items') ?>
    <?php // echo $form->field($model, 'buyer_email') ?>
    <?php // echo $form->field($model, 'note') ?>
    <?php // echo $form->field($model, 'city') ?>
    <?php // echo $form->field($model, 'phone') ?>
    <?php // echo $form->field($model, 'hash_key') ?>
    <?php // echo $form->field($model, 'entry_at') ?>
    
    <div class="form-group">
        <label>Filter Date</label>
        <input type="text" class="form-control" name="daterange" value="<?php echo $_POST["daterange"] ?>">
        <div class="invalid-feedback">
            This field have to be date
        </div>
    </div>

    




    <button class="btn btn-success">Submit</button>
<?php Form::end() ?>

<table class="table table-striped table-bordered table-responsive">
    <thead class="thead-dark">
        <tr>
            <?php
                foreach($report[0] as $key=>$value){
                    
                    echo '<th scope="col"> '.$key.' </th>';
                    
                }
            ?>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($report as $row){
                echo '<tr>';
                    foreach($row as $cell){   
                        echo '<td>'.$cell.'</td>';
                    }
                echo '</tr>';
            }
        ?>
        
    </tbody>
</table>

<!-- <input type="text" name="daterange" value="01/01/2018 - 01/15/2018" /> -->





