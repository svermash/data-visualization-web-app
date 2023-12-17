<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>upload form</title>

    <style>


    .upload-btn{
    width: 100%;
    height: 35px;
    background: blue;
    border: none;
    outline: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 1.2em;
    color: white;
    font-weight: 500;
}
.grand-wrapper{
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 70vh;
}
.form-box{
    position: center;
    width: 300px;
    height: 340px;
    background: #bcc8fc;
    border: 2px solid black;
    border-radius: 5px;
    box-shadow: 0 0 30px rgba(0, 0, 0, .5);
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden;

}

.hTwo{
    font-size: 2em;
    color: blue;
    text-align: center;
}


    </style>
</head>
<body>
    <h1 align="center">Add a result</h1><br>

    <div class="grand-wrapper">

    <div class="form-box">

<form id="upload-form" action="upload_logic.php" method="post" enctype="multipart/form-data" >



<table border=0 align="center">
<tr>
<td colspan=2 class="hTwo">Adding a result</td>
</tr>


                    <tr>
                    <td colspan ="2"></td>
                    </tr>
                    <tr>
                    <td colspan ="2"></td>
                    </tr>
    <tr>
    <td colspan=2><input type="file" name="file" id="file" required></td>
    </tr>

    <tr>
    <td><label>Result name:</label></td>
    <td><input type="text" name="input_name" id="input_name" placeholder="eg. SEM_1" required ></td>
    </tr>

    <tr>
    <td colspan=2><input type="submit" class="upload-btn" value="Add result" name="submit"></td>
    </tr>

</table>


</form>

</div>
</div>
</body>
</html>


