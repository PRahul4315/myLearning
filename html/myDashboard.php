<?php
include("pagesection.php");
headStart();
?>
<script>
    app.controller("dashCtrl", function($scope) {

  

    });
</script>
<?php
headEnd();
bodyStart();
layoutWrapperStart();
layoutContainerStart();
menuBar();
layoutPageContainerStart();
NavBar();
contentWrapperStart();
?>

<div class="row" ng-controller="dashCtrl">

    <div class="col-lg-8 mb-4 order-0">
        <div class="card">
            <div class="d-flex align-items-end row">
                <div class="col-sm-7">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Welcome Rahul ! 🎉</h5>
                        <p class="mb-4">
                            This is a Dashboard
                        </p>

                        <button ng-click="callModal()" class="btn btn-sm btn-outline-primary">Open Modal</button>
                    </div>
                </div>
                <div class="col-sm-5 text-center text-sm-left">
                    <div class="card-body pb-0 px-0 px-md-4">
                        <img src="../assets/img/illustrations/man-with-laptop-light.png" height="140" alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png" data-app-light-img="illustrations/man-with-laptop-light.png">
                    </div>
                </div>
            </div>
        </div>
    </div>



</div>
<?php
contentWrapperEnd();
layoutPageContainerEnd();
layoutContainerEnd();
layoutWrapperEnd();
bodyEnd();
?>