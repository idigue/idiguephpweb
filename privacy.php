<!doctype html>
<html lang="en">
<?php include 'components/head.php'; ?>
<?php include 'components/breadcrumb.php'; ?>
<body>
    <?php

    $sqlfetchalltutorials = "SELECT * FROM `tutorials`";
    $tutorials = $db_handle->runQuery($sqlfetchalltutorials);

    ?>
    
    <div class="text-center">
        <div id="accordion">
            <div class="card" style="background-color: #333;">
                <?php
                if (count($tutorials) > 0) :
                    foreach ($tutorials as $tutorial) :
                ?>
                        <div class="card-header" id=<?php echo 'heading' . $tutorial['id']; ?>>
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target=<?php echo '#collapse' . $tutorial['id']; ?> aria-expanded="true" aria-controls=<?php echo 'collapse' . $tutorial['id']; ?>>
                                    <?php echo $tutorial['title']; ?>
                                </button>
                            </h5>
                        </div>

                        <div id=<?php echo 'collapse' . $tutorial['id']; ?> class="collapse show" aria-labelledby=<?php echo 'heading' . $tutorial['id']; ?> data-parent="#accordion">
                            <div class="card-body">
                                <?php echo $tutorial['contents']; ?>

                            </div>
                        </div>

                    <?php endforeach; ?>
                <?php endif ?>
            </div>
        </div>
    </div>
    </div>
    </div><br>
    <div class="text-center">
        <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-c-circle" viewBox="0 0 16 16">
                <path d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8m15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.146 4.992c-1.212 0-1.927.92-1.927 2.502v1.06c0 1.571.703 2.462 1.927 2.462.979 0 1.641-.586 1.729-1.418h1.295v.093c-.1 1.448-1.354 2.467-3.03 2.467-2.091 0-3.269-1.336-3.269-3.603V7.482c0-2.261 1.201-3.638 3.27-3.638 1.681 0 2.935 1.054 3.029 2.572v.088H9.875c-.088-.879-.768-1.512-1.729-1.512" />
            </svg> 2025 iDIGUE</p>
    </div>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/site.js" asp-append-version="true"></script>
</body>

</html>