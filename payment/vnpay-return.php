<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="main.css">
    <link rel='stylesheet' type='text/css' href='../common/css/header.css'>
    <script src="main.js"></script>
    <title>Profile</title>
</head>

<body style="background-color: #eef0f1;">
    <?php require '../common/header.php'; ?>
    <?php
    if (!isset($_GET['vnp_TxnRef'])) {
        header("Location: ../home/home.php");
    }
    ?>

    <div class="container" style="margin-top: 100px;">
        <div class="row my-5">
            <div class="col-12 bg-white p-3 border border-2 shadow rounded">
                <table class="table table-striped ">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Value</th>
                            <th scope="col">Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Merchant Id</td>
                            <td><?php echo $_GET['vnp_TmnCode']; ?></td>
                            <td>Provided by VNPAY</td>
                        </tr>
                        <tr>
                            <td>Amount</td>
                            <td><?php echo $_GET['vnp_Amount'] / 100; ?></td>
                            <td>Number of payment</td>
                        </tr>
                        <tr>
                            <td>Transaction info</td>
                            <td><?php echo strtotime($_GET['vnp_PayDate']); ?></td>
                            <td>Payment time</td>
                        </tr>
                        <tr>
                            <td>Current Code</td>
                            <td><?php echo 'VND'; ?></td>
                            <td>Current of payment</td>
                        </tr>
                        <tr>
                            <td>Message</td>
                            <td><?php echo $_GET['vnp_OrderInfo']; ?></td>
                            <td>Message send to receiver</td>
                        </tr>
                        <tr>
                            <td>Bank</td>
                            <td><?php echo $_GET['vnp_BankCode']; ?></td>
                            <td>Bank transaction</td>
                        </tr>
                        <tr>
                            <td>Transaction Number</td>
                            <td><?php echo $_GET['vnp_TransactionNo']; ?></td>
                            <td>Transaction Number on payment gateway</td>
                        </tr>
                        <tr>
                            <td>Bank Transaction Number</td>
                            <td><?php echo $_GET['vnp_BankTranNo']; ?></td>
                            <td>Transaction Number in bank</td>
                        </tr>
                        <tr>
                            <td>Response Code</td>
                            <td><?php echo $_GET['vnp_ResponseCode']; ?></td>
                            <td>Status of transaction</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php require '../common/footer.php'; ?>

</body>

</html>