<?php include("common.php"); ?>

<?php
	$presentation_name = $_GET["pres_name"];
 ?>


 <h3><a href="index.php">Back to home</a></h3>

 <h3>Presentation: <i><?php echo $presentation_name; ?></i></h3>

<a class="num" href="javascript:;">Numeric</a> | <a class="cus" href="javascript:;">Custom</a>

<form action="rename_module.php" style="display: none;" class="num_input">
    <input type="hidden" name="current_presentation" value="<?php echo $presentation_name; ?>">
    <input type="text" name="rename_module" placeholder="Enter name pattern here" style="width: 50%">
    <input type="submit" value="Rename">
</form>

<hr>
<h3>Slides:</h3>
 <?php 
 $slides = scandir("uploads/".$presentation_name);
 for ($a = 2; $a < count($slides); $a++) { ?>
    <p data-slide='<?php echo $slides[$a]; ?>' class="slide_name">
        <div><?php echo $slides[$a]; ?>  <input type="text" class="cus_input" style="width: 50%;display: none;">  </div>
    </p>
<?php }  ?>


<br><hr><br>

<script src="jquery.js"></script>
<script>
   // $(document).ready(function(){
        $(".num").on('click', function(){
            $(".cus_input").hide();
            $(".num_input").show();
        });
        $(".cus").on('click', function(){
            $(".cus_input").show();
            $(".num_input").hide();
        });
    //});
</script>



