<?php include("common.php"); ?>

<?php
	$presentation_name = $_GET["pres_name"];
 ?>


 <a href="index.php">Back</a>

 <h3>Presentation: <i><?php echo $presentation_name; ?></i></h3>


<div class="naming-option">
    <a class="num" href="javascript:;">Numeric</a> <a class="cus" href="javascript:;">Custom</a> <a class="replace" href="javascript:;">Find & Replace</a>
</div>

<br>

<div class="num_input" style="display: none;">
    <form action="rename_module.php">
        <input type="hidden" name="current_presentation" value="<?php echo $presentation_name; ?>">
        <input type="text" name="rename_module" placeholder="Enter name pattern here" style="width: 30%"> | 
        <input type="number" name="init_num" placeholder="Enter init number" style="width: 10%"> |
        <input type="submit" value="Rename">
    </form>
</div>

<div class="replace_input" style="display: none;">   
    <form action="find-replace.php">
        <input type="hidden" name="current_presentation" value="<?php echo $presentation_name; ?>">
        <input type="text" name="find" placeholder="Find" style="width: 40%;"> | 
        <input type="text" name="replace" placeholder="Replace with" style="width: 40%;"> |
        <input type="submit" value="Replace">
    </form>
</div>  

<h3>Slides:</h3>
 <?php 
 $slides = scandir("uploads/".$presentation_name);
 for ($a = 2; $a < count($slides); $a++) { ?>
    <p data-slide='<?php echo $slides[$a]; ?>' class="slide_name">
        <div>
            <?php echo $slides[$a]; ?>  
            <form action="custom_name.php" class="cus_input" style="display: none;">
                <input type="hidden" name="current_presentation" value="<?php echo $presentation_name; ?>">
                <input type="hidden" name="current_slide" value="<?php echo $slides[$a]; ?>">
                <input type="text" placeholder="Enter new name here!" style="width: 50%;" name="new_name"> | 
                <input type="submit" value="Rename">
            </form>
        </div>
    </p>
<?php }  ?>


<script src="jquery.js"></script>
<script>
   $(document).ready(function(){
        $(".naming-option a").click(function(){
            $(".naming-option a").removeClass("active");
            $(this).addClass("active");
        });

        $(".num").on('click', function(){
            $(".cus_input, .replace_input").hide();
            $(".num_input").show();
        });
        $(".cus").on('click', function(){
            $(".num_input, .replace_input").hide();
            $(".cus_input").show();
        });
        $(".replace").on('click', function(){
            $(".cus_input, .num_input").hide();
            $(".replace_input").show();
        });
    });
</script>



