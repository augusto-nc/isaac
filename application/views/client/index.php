<section class="section bg-cover bg-dark" style="background: url(<?php echo base_url('assets/banner.png')?>);background-size: cover;background-repeat: no-repeat;">
    <div class="container">
        <div class="row justify-content-center" style="min-height: 480px;">
            <div class="col-lg-7 col-xl-6 text-center pt-5">
                <br>
                <br>
                <br>
                <br>
                <h1 class="mb-3 text-white mb-4 encontre-veganos">Encontre produtos veganos</h1>
                  <br>
                <form class="d-flex flex-row mb-2 p-1 bg-white shadow-lg input-group rounded-3" style="border-radius: 19.3rem!important">
                    <input type="text" class="form-control form-control-lg rounded-0 border-0 shadow-none" placeholder="Digite o nome do produto e descubra se é vegano"  style="border-radius: 19.3rem!important">
                </form>
            </div>
        </div>
    </div>
</section>


<div class="clearfix"></div>
<br><br>

<section class="section bg-gray-100">
    <div class="container">
        <div class="row mb-5 align-items-center">
            <div class="col">
                <h1 class="mb-0">Produtos</h1>
                <p>Veja nossa lista de Produtos</p>
            </div>

        </div>



        <?php

        $endpoint = 'https://wikiveg-1.web.app/web/products/bebidas-veganas/';

        $json_url = $endpoint;
        $json = file_get_contents($json_url);
        $json=str_replace('},

]',"}

]",$json);
        $data = json_decode($json);


        ?>
        <!-- Products -->
        <div class="row g-3 g-xl-4">

            <?php foreach ($data as $values){?>

            <div class="col-md-6 col-lg-4">
                <div class="card shadow-hover">
                    <a href="#">
                        <img class="card-img-top" src="<?php echo $values->url?>" title="" alt="">
                    </a>
                    <div class="card-body p-3">
                        <span class="small"><?php echo $values->brand;?></span>
                        <h4 class="m-0"><a class="text-reset text-truncate d-block w-100" href="#" style="text-decoration: none;"><?php echo $values->name;?></a></h4>

                    </div>

                    <div class="card-footer border-top d-flex px-3">

                    <div>
                        <span>Total de Votos</span>
                        <div class="text-warning small">
                            <span class="text-body small"><?php echo $values->qtd_review;?> votos</span>
                        </div>
                    </div>

                    </div>
                    <div class="card-footer border-top d-flex px-3">

                        <div class="ms-auto position-relative z-index-1">

                                <a class="btn btn-success btn-sm me-2" href="#"><i class="fas fa-users"></i> <?php echo $values->vegan;?> veganos</a>
                                <a class="btn btn-outline-success btn-sm me-2" href="#"><i class="fas fa-users"></i> <?php echo $values->vegetal;?> vegetal</a>
                                <a class="btn btn-outline-success btn-sm me-2" href="#"><i class="fas fa-users"></i> <?php echo $values->no_vegan;?> N vegetal</a>
                        </div>
                    </div>
                </div>
            </div>

            <?php } ?>
        </div>
        <!-- End Products -->
    </div>
</section>