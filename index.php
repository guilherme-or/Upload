<?php

// Functions
function readExt($path)
{
    $exts = array();
    $contents = file_get_contents($path);
    $exts = explode("\n", $contents);
    return $exts;
}

function showInfo($file)
{
    return 'Nome: ' . $file['name'] . '<br>Tamanho: ' . $file['size'] . ' bytes <br>Data: ' . date("d/m/Y");
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload de arquivos</title>
    <!-- Link Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- Link CSS -->
    <link rel="stylesheet" href="./includes/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href=""><img src="./includes/img/logo.png"></a>
    </nav>

    <!-- OBRIGATORIO: enctype="multipart/form-data". Usado para forms que dão submit em input do tipo file. -->
    <main class="container mt-5">
        <section class="card">
            <div class="card-header">
                <h1>Upload de arquivos</h1>
            </div>
            <div class="card-body">
                <form method="POST" action="index.php" enctype="multipart/form-data" class="form" id="form">
                    <div class="form-group">
                        <!-- <label for="file" class="" name="file-label"><i class="fa-solid fa-cloud-arrow-up"></i>Escolha o arquivo</label> -->
                        <input type="file" id="file" name="file">
                    </div>
                    <div class="form-group" id="container-btn">
                        <button type="submit" class="btn btn-primary" name="btn-upload">Upload</button>
                    </div>
                </form>
            </div>
        </section>
    </main>

    <?php

    if (isset($_POST['btn-upload'])) {
        $dir = "Arquivos/";
        $txt = "info.txt";

        $exts = readExt($txt);

        $file = $_FILES['file'];
        $file_ext = explode('.', $file['name']);

        if (array_search($file_ext[1], $exts) === false) {
            echo 'O tipo do arquivo não é suportado';
        } else {
            // move o arquivo
            if (move_uploaded_file($file['tmp_name'], $dir . $file['name'])) {
                echo 'Upload do arquivo realizado com sucesso!' . showInfo($file);
            } else {
                echo 'Erro no upload: <br>' . $file['error'];
            }
        }
    }

    ?>

</body>

</html>