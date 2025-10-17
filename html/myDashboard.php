<?php
include("pagesection.php");
headStart();
?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>

    app.controller("dashCtrl", function($scope, $http, $rootScope) {

        $scope.startDate = "";
        $scope.currentDate = new Date();
        $scope.total = 0;

        $rootScope.getConsistency = function() {

            $http.get("../API/checkConsistency.php").then(function(response) {

                console.log(response);
                $scope.total = response.data.length;
                $scope.startDate = new Date(response.data[0].created_on);
                $rootScope.apiData = response.data;


                // Prepare data for Chart.js
                $scope.labels = $rootScope.apiData.map(item => item.task);
                $scope.consistencyValues = $rootScope.apiData.map(item => item.consistency);
                $scope.totalDays = $rootScope.apiData.map(item => item.total_days);
                $scope.completedDays = $rootScope.apiData.map(item => item.completed_days);

                // Chart configuration
                const data = {
                    labels: $scope.labels,
                    datasets: [{
                        label: 'Task Consistency (%)',
                        data: $scope.consistencyValues,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(255, 159, 64, 0.2)',
                            'rgba(255, 205, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(201, 203, 207, 0.2)'
                        ],
                        borderColor: [
                            'rgb(255, 99, 132)',
                            'rgb(255, 159, 64)',
                            'rgb(255, 205, 86)',
                            'rgb(75, 192, 192)',
                            'rgb(54, 162, 235)',
                            'rgb(153, 102, 255)',
                            'rgb(201, 203, 207)'
                        ],
                        borderWidth: 1
                    }]
                };

                const config = {
                    type: 'bar',
                    data: data,
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: 100,
                                title: {
                                    display: true,
                                    text: 'Consistency (%)'
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Tasks'
                                }
                            }
                        },
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const i = context.dataIndex;
                                        return `${$rootScope.apiData[i].task}: ${$rootScope.apiData[i].consistency}% (${ $scope.completedDays[i] } of ${ $scope.totalDays[i] } days)`;
                                    }
                                }
                            }
                        }
                    }
                };

                // Initialize Chart
                const ctx = document.getElementById('consistencyChart').getContext('2d');
                new Chart(ctx, config);

            }, function(response) {
                console.log(response);

            })
        }


        $rootScope.getConsistency();

        // $scope.getStartingDate();
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
                            You have done % work till yet. Check <br>your new update's in your profile.
                        </p>

                        <button ng-click="callModal()" class="btn btn-sm btn-outline-primary">Your Consistency</button>
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
    <div class="col-lg-4 col-md-4 order-1">
        <div class="row">
            <div class="col-lg-6 col-md-12 col-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <img
                                    src="../assets/img/icons/unicons/chart-success.png"
                                    alt="chart success"
                                    class="rounded" />
                            </div>
                            <div class="dropdown">
                                <button
                                    class="btn p-0"
                                    type="button"
                                    id="cardOpt3"
                                    data-bs-toggle="dropdown"
                                    aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                                    <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                </div>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1">Start Date</span>
                        <h3 class="card-title mb-2">{{startDate.toDateString().split(" ").slice(0, 3).join(" ")}}</h3>
                        <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i>{{startDate.getFullYear()}}</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <img
                                    src="../assets/img/icons/unicons/wallet-info.png"
                                    alt="Credit Card"
                                    class="rounded" />
                            </div>
                            <div class="dropdown">
                                <button
                                    class="btn p-0"
                                    type="button"
                                    id="cardOpt6"
                                    data-bs-toggle="dropdown"
                                    aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                                    <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                </div>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1">Today's Date</span>
                        <h3 class="card-title mb-2">{{currentDate.toDateString().split(" ").slice(0, 3).join(" ")}}</h3>
                        <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i>{{currentDate.getFullYear()}}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Total Revenue -->
    <div class="col-12 col-lg-8 order-2 order-md-3 order-lg-2 mb-4">
        <div class="card">
            <div class="row row-bordered g-0">
                <div class="col-md-8">
                    <h5 class="card-header m-0 me-2 pb-3">Total Consistency</h5>
                    <div id="totalRevenueChart" class="px-2"></div>
                </div>

                <!-- <div class="col-md-4"> -->
                <!-- <div class="card-body">
                        <div class="text-center">
                            <div class="dropdown">
                                <button
                                    class="btn btn-sm btn-outline-primary dropdown-toggle"
                                    type="button"
                                    id="growthReportId"
                                    data-bs-toggle="dropdown"
                                    aria-haspopup="true"
                                    aria-expanded="false">
                                    2022
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="growthReportId">
                                    <a class="dropdown-item" href="javascript:void(0);">2021</a>
                                    <a class="dropdown-item" href="javascript:void(0);">2020</a>
                                    <a class="dropdown-item" href="javascript:void(0);">2019</a>
                                </div>
                            </div>
                        </div>
                    </div> -->
                <!-- <div id="growthChart"></div>
                    <div class="text-center fw-semibold pt-3 mb-2">62% Company Growth</div> -->

                <!-- <div class="d-flex px-xxl-4 px-lg-2 p-4 gap-xxl-3 gap-lg-1 gap-3 justify-content-between">
                        <div class="d-flex">
                            <div class="me-2">
                                <span class="badge bg-label-primary p-2"><i class="bx bx-dollar text-primary"></i></span>
                            </div>
                            <div class="d-flex flex-column">
                                <small>2022</small>
                                <h6 class="mb-0">$32.5k</h6>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="me-2">
                                <span class="badge bg-label-info p-2"><i class="bx bx-wallet text-info"></i></span>
                            </div>
                            <div class="d-flex flex-column">
                                <small>2021</small>
                                <h6 class="mb-0">$41.2k</h6>
                            </div>
                        </div>
                    </div> -->
                <!-- </div> -->

                <canvas id="consistencyChart" width="400" height="200"></canvas>


            </div>
        </div>
    </div>
    <!--/ Total Revenue -->
    <div class="col-12 col-md-8 col-lg-4 order-3 order-md-2">
        <div class="row">
            <div class="col-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <img src="../assets/img/icons/unicons/paypal.png" alt="Credit Card" class="rounded" />
                            </div>
                            <div class="dropdown">
                                <button
                                    class="btn p-0"
                                    type="button"
                                    id="cardOpt4"
                                    data-bs-toggle="dropdown"
                                    aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt4">
                                    <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                </div>
                            </div>
                        </div>
                        <span class="d-block mb-1">TotalTask</span>
                        <h3 class="card-title text-nowrap mb-2">{{total}}</h3>
                        <small class="text-danger fw-semibold"><i class="bx bx-up-arrow-alt"></i> Total Count</small>
                    </div>
                </div>
            </div>
            <div class="col-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <img src="../assets/img/icons/unicons/cc-primary.png" alt="Credit Card" class="rounded" />
                            </div>
                            <div class="dropdown">
                                <button
                                    class="btn p-0"
                                    type="button"
                                    id="cardOpt1"
                                    data-bs-toggle="dropdown"
                                    aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="cardOpt1">
                                    <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                </div>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1">Status</span>
                        <h3 class="card-title mb-2">Active</h3>
                        <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> Active Status</small>
                    </div>
                </div>
            </div>
            <!-- </div>
               <div class="row"> -->
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                            <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                                <div class="card-title">
                                    <h5 class="text-nowrap mb-2">Profile Report</h5>
                                    <span class="badge bg-label-warning rounded-pill"> YEAR {{currentDate.getFullYear()}}</span>
                                </div>
                                <div class="mt-sm-auto">
                                    <small class="text-success text-nowrap fw-semibold"><i class="bx bx-chevron-up"></i> Task <i class="bx bx-right-arrow-alt"></i>{{total}}</small>
                                    <h3 class="mb-0">$84,686k</h3>
                                </div>
                            </div>
                            <div id="profileReportChart"></div>
                        </div>
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