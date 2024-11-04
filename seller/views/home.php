<div ng-controller="HomeController">
    <?php 
    session_start();
    ?>
    <h1>Example Data <?=$_SESSION["storeCode"]?></h1>
    <ul>
        <li ng-repeat="item in items">{{ item.name }}</li>
    </ul>
    <button ng-click="sendData()" class="btn btn-primary">Send Data</button>
    <p>{{ message }}</p>
</div>
