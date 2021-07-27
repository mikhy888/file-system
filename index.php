<?php include("common.php"); ?>

<h3>Upload New Presentation:</h3>

<form method="POST" action="upload.php" enctype="multipart/form-data">
    <input type="file" name="file">
    <input type="submit" value="Upload">
</form>
<br>

<div id="result"></div>

<hr>

<?php

$files = scandir("uploads"); ?>
<h3>Presentations:</h3>
<?php
for ($a = 2; $a < count($files); $a++) {
    ?>
    <p>
        <div class="pres-details">
                <b><?php echo $files[$a]; ?> | </b>
                <a href="rename.php?pres_name=<?php echo $files[$a]; ?>" style="color: black;">Rename</a> | 
                <a href="download-as-unzipped.php?pres_name=<?php echo $files[$a]; ?>&method=zipped">Download as unzipped</a> |
                <a href="download-as-zipped.php?pres_name=<?php echo $files[$a]; ?>">Download as zipped</a> |
                <a href="delete.php?name=<?php echo $files[$a]; ?>" style="color: red;">Delete</a>
        </div>
    </p>
    <?php
}
?>
<style>
    .fixed-bottom {
        position: fixed;
        left: 0;
        bottom: 0;
        width: 100%;
        background-color: lightseagreen;
        color: white;
        text-align: center;
        padding: 25px;
        font-size: 20px;
    }
    .pres-details a {
        font-size: 15px;
        color: black;
        margin-left: 3px;
    }
</style>


<br>

