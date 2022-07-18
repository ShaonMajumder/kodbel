<?php
/** @var $model \thecodeholic\phpmvc\Model */

use thecodeholic\phpmvc\form\Form;

$form = new Form();
$this->title = 'Buyer';

?>

<h1>Report</h1>


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

