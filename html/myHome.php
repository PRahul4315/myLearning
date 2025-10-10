<?php
include("pagesection.php");
headStart();
?>
<script>
  var tableHead = document.getElementById("tableHead");
  var tableRow = document.getElementById("tableRow");
  let taskCounter = 0;
  let TaskCreatedDate = new Date();
  // let TaskCreatedDate = new Date("2025-10-07");

  app.controller("taskCtrl", function($scope, $rootScope, $http, $filter) {

    $rootScope.tasksCheck = [];
    $rootScope.FiltertasksCheck = [];

    $rootScope.getTasks = function() {

      $http.get("../API/getTaskName.php").then(function(response) {

        if (response.data.length != 0) {
          $rootScope.tasks = response.data;
          TaskCreatedDate = new Date($rootScope.tasks[0].createdon);
          // console.log("createdDate", $rootScope.tasks[0].createdon);
          // console.log(TaskCreatedDate);
           
        }else{
          $rootScope.tasks = response.data;
        }

        // console.log($rootScope.tasks);
      }, function(error) {
        console.error("Error fetching tasks:", error);
      });

    }

    $rootScope.getTaskCheck = function() {
      $http.get("../API/getTaskCheck.php").then(function(response) {
        $rootScope.tasksCheck = response.data.map(item => ({
          ...item,
          // Convert MySQL datetime string -> JS Date in same format
          date: new Date(item.date.split(" ")[0] + "T00:00:00.000Z"),
          checked: item.checked === true || item.checked === 1
        }));
        // console.log($rootScope.tasksCheck);
      }, function(error) {
        console.error("Error fetching tasks:", error);
      });
    };


    $rootScope.validateTaskCheckBox = function(task, date) {
      if (task.checked) {

        // $rootScope.tasksCheck.push(task);

        $rootScope.tasksCheck.push({
          id: task.id,
          task: task.task, // or task.task depending on your object
          date: new Date($filter('date')(date, 'yyyy-MM-dd')),
          checked: true
        });

      } else {
        $rootScope.tasksCheck = $rootScope.tasksCheck.filter(t => t.id !== task.id);
      }
    }



    $rootScope.AddTaskChecked = function(id) {

      $rootScope.FiltertasksCheck = $rootScope.tasksCheck.filter(t => $filter('date')(t.date, 'yyyy-MM-dd') === $filter('date')(id, 'yyyy-MM-dd'));
      console.log($rootScope.FiltertasksCheck);

      $http.post("../API/addTaskCheck.php", $rootScope.FiltertasksCheck)
        .then(function(response) {
          console.log("Data saved successfully:", response.data);
          if (response.data.Success) {

            Swal.fire({
              title: "Data Saved Successfully",
              icon: "success",
              draggable: true
            });

          }
        })
        .catch(function(error) {
          console.error("Error saving data:", error);
        });

    }

    $scope.isTaskChecked = function(taskId, date) {
      const formattedDate = $filter('date')(date, 'yyyy-MM-dd');
      return $rootScope.tasksCheck.some(item =>
        item.id == taskId &&
        $filter('date')(item.date, 'yyyy-MM-dd') === formattedDate &&
        item.checked
      );
    };


    $scope.getDateKey = function(d) {
      return $filter('date')(d, 'yyyy-MM-dd');
    };


    $scope.AddTaskModal = function() {
      taskCounter = 1;
      $rootScope.AddTask = [];
      $rootScope.AddTask.push({
        id: taskCounter,
        task: ""
      });

      $("#AddModalId").modal("show");
    }

    $scope.EditTaskModal = function() {
      $("#EditModalId").modal("show");

      $rootScope.EditTask = [...$rootScope.tasks]

    }

    $rootScope.getTasks();
    $rootScope.getTaskCheck();

  });

  app.controller("AddTaskCtrl", function($scope, $rootScope, $http) {

    $rootScope.startDate = TaskCreatedDate;
    $rootScope.today = new Date();
    $rootScope.current = new Date($rootScope.startDate);
    $rootScope.dates = [];



    while ($rootScope.current <= $rootScope.today) {
      $scope.dates.push(new Date($rootScope.current));
      $rootScope.current.setDate($rootScope.current.getDate() + 1);
    }

    $rootScope.tasks = [];
    $rootScope.AddTask = [];
    $rootScope.EditBtn = true;


    $rootScope.AddTaskFunction = function() {
      taskCounter++;
      $rootScope.AddTask.push({
        id: taskCounter,
        task: ""
      });

    };

    $scope.RemoveTaskFunction = function(id) {
      console.log(id);
      console.log($rootScope.tasks);


      $rootScope.AddTask = $rootScope.AddTask.filter(t => t.id !== id);
    };

    $rootScope.saveTaskFunction = function(opr) {

      if (opr === 'Add') {

        $rootScope.tasks = $rootScope.AddTask.reduce((acc, {
          task
        }) => {
          if (task.trim() !== "") {
            acc.push({
              task
            });
          } else {
            $rootScope.getTasks();
          }
          return acc;
        }, []);

      } else {

        $rootScope.tasks = $rootScope.EditTask.reduce((acc, {
          id,
          task
        }) => {
          if (task.trim() !== "") {
            acc.push({
              id,
              task
            });
          }
          return acc;
        }, []);;

      }

      $http.post("../API/addTaskName.php", $rootScope.tasks)
        .then(function(response) {
          // console.log("Data saved successfully:", response.data);
          if (response.data.Success) {
            $rootScope.getTasks();
            $rootScope.tasks = [];
            $rootScope.AddTaskFunction();
            Swal.fire({
              title: "Data Saved Successfully",
              icon: "success",
              draggable: true
            });

          }
        })
        .catch(function(error) {
          console.error("Error saving data:", error);
        });

      $("#AddModalId").modal("hide");
    };

    $rootScope.AddTaskFunction();
  });

  app.controller("EditTaskCtrl", function($scope, $rootScope, $http) {
    // $rootScope.EditTask = [...$rootScope.tasks];

    $rootScope.editTaskFunction = function() {
      $rootScope.saveTaskFunction('Edit');
      $("#EditModalId").modal("hide");
    }

    $rootScope.RemoveEditTaskFunction = function(task) {

      if (task) {
        $("#EditModalId").modal("hide");
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {

            $http.post("../API/deleteTaskName.php", {
                id: task
              })
              .then(function(response) {
                // console.log("Deleted Data successfully:", response);
                if (response.data.Success) {
                  $rootScope.getTasks();
                  Swal.fire({
                    title: "Data Deleted Successfully",
                    icon: "success",
                    draggable: true
                  });
                }
              })
              .catch(function(error) {
                console.error("Error saving data:", error);
              });

            $rootScope.EditTask = $rootScope.EditTask.filter(t => t.id !== task);

            Swal.fire(
              'Deleted!',
              'Your file has been deleted.',
              'success'
            )
          }
        })

      }
    }

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

<div ng-controller="taskCtrl">

  <div class="card">
    <div class=" d-flex align-items-center justify-content-between ">

      <h5 class="card-header">Task Table</h5>
      <span class="d-flex align-items-center justify-content-center">
        <button type="button" ng-click="EditTaskModal()" class=" me-4 btn btn-warning"><i class="fa-solid fa-pen-to-square"></i> Edit Task</button>

        <button type="button" ng-click="AddTaskModal()" class=" me-4 btn btn-info"><i class="fa-solid fa-plus "></i> Add Task</button>
      </span>
    </div>
    <div class="table-responsive text-nowrap">
      <table class="table">
        <thead class="table-dark">
          <tr id="tableHead">

            <th style="color:rgb(184,184,184);text-align:center;" ng-style="tasks.length > 0 ? {'display':'none'} : {}"></th>
            <th style="color:rgb(184,184,184);" ng-style="tasks.length == 0 ? {'display':'none'} : {}"> Date'S </th>
            <th style="color:rgb(184,184,184);" ng-repeat=" t in tasks">{{t.task}}</th>
            <th style="color:rgb(184,184,184);" ng-style="tasks.length == 0 ? {'display':'none'} : {}">Save</th>

          </tr>
        </thead>
        <tbody class="table-border-bottom-0">

          <tr ng-repeat="d in dates" id="tableRow" ng-style="tasks.length == 0 ? {'height': '70px'} : {}">
            <td style="text-align:center;" ng-style="tasks.length > 0 ? {'display':'none'} : {}">Please Add Some Task</td>
            <td ng-style="tasks.length == 0 ? {'display':'none'} : {}">{{d | date:'yyyy-MM-dd'}}</td>
            <td ng-repeat="t in tasks">
              <div class="form-check">
                <input class="form-check-input"
                  type="checkbox" value="{{t.id}}"
                  ng-attr-id="{{ (d | date:'yyyy-MM-dd') + '_' + t.id }}"
                  ng-model="t.checked[getDateKey(d)]"
                  ng-checked="isTaskChecked(t.id, d)"
                  ng-change="validateTaskCheckBox(t,d)" />
                <label class="form-check-label cursor-pointer"
                  ng-attr-for="{{ (d | date:'yyyy-MM-dd') + '_' + t.id }}" >Checked</label>
              </div>
            </td>
            <td ng-style="tasks.length == 0 ? {'display':'none'} : {}" ><button type="button" ng-click="AddTaskChecked(d)" class=" me-4 btn rounded-pill btn-icon btn-warning text-black"><i class="fa-solid fa-check"></i></button></td>
          </tr>



        </tbody>
      </table>
    </div>
  </div>


</div>

<?php
ModalStart("AddModalId", "Add Task List", "AddTaskCtrl", "saveTaskFunction('Add')", "AddTaskCtrl", "modal-lg");
?>

<div class="d-flex align-items-center justify-content-end">
  <button type="button" ng-click="AddTaskFunction()" class="btn btn-info"><i class="fa-solid fa-plus"></i>Add Task</button>
</div>
<div id="taskContainer">
  <div ng-repeat="task in AddTask"
    id="taskDiv-{{task.id}}"
    class="d-flex align-items-center justify-content-center gap-3 mt-3">

    <div class="w-100">
      <input type="text"
        class="form-control"
        ng-model="task.task"
        required
        placeholder="Task {{task.id}}">
    </div>

    <span ng-click="RemoveTaskFunction(task.id)"
      class="badge badge-center rounded-pill bg-label-danger text-center cursor-pointer">
      X
    </span>
  </div>
</div>

<?php
ModalEnd("Save", "saveTask", "submit", true);
?>

<?php
ModalStart("EditModalId", "Edit Task List", "EditTaskCtrl", "editTaskFunction()", "EditTaskCtrl", "modal-lg");
?>

<div class="d-flex align-items-center justify-content-end">

</div>
<div id="taskContainer">
  <div ng-repeat="task in EditTask"
    id="taskDiv-{{task.id}}"
    class="d-flex align-items-center justify-content-center gap-3 mt-3">

    <div class="w-100">
      <input type="text"
        class="form-control"
        ng-model="task.task"
        placeholder="Task {{task.id}}">
    </div>

    <span ng-click="RemoveEditTaskFunction(task.id)"
      class="fs-4 cursor-pointer">
      <i class="fa-solid fa-trash"></i>
    </span>
  </div>
</div>

<?php
ModalEnd("Save", "saveTask", "submit", true);
?>


<?php
contentWrapperEnd();
layoutPageContainerEnd();
layoutContainerEnd();
layoutWrapperEnd();
bodyEnd();
?>