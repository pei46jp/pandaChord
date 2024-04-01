<h2 class="pt-4 text-center"><?php echo $data['songs']['title'] ?></h2>
<h3 class="pt-2 text-center"><?php echo $data['songs']['artist_name'] ?></h3>
<div class="container py-3 my-5">
    <div class="row">
        <div class="col-sm-10">
            <div class="container">
                <div class="row">
                    <div class="col-6">
                        <p><?php echo $data['songs']['lyrics'] ?></p>
                    </div>
                    <div class="col-6">
                        <p><?php echo $data['songs']['chord'] ?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <p><?php echo $data['songs']['memo'] ?></p>
                    </div>
                    <div class="col-xs-12">
                        <p>More Function</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>