

<?php
include '../../../Config/Database.php';
include '../../../Router/Admin/admin_login.php';

// ตรวจสอบว่ามีค่า id ที่ถูกส่งมาหรือไม่
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // ดึงข้อมูลผู้ใช้จากฐานข้อมูล
    $sql = "SELECT * FROM users WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // ตรวจสอบว่าพบข้อมูลผู้ใช้หรือไม่
    if ($user) {
        // ดึงข้อมูลอื่นๆ ที่ต้องการใช้ในการแสดงผลหน้าแก้ไข
        $firstname = $user['firstname'];
        $lastname = $user['lastname'];
        $email = $user['email'];
        $profile_img2 = $user['profile_img'];
        $user_id = $user['id'];
    } else {
        // ไม่พบข้อมูลผู้ใช้ ทำการแจ้งเตือนหรือการจัดการตามความเหมาะสม
    }
} else {
    // ถ้าไม่ได้ส่งค่า id มาใน URL ให้ทำการแจ้งเตือนหรือการจัดการตามความเหมาะสม
}

// ต่อจากโค้ดอื่น ๆ ที่คุณมี
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../../Image/logo.png">
    <title>Event Details</title>
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.7.0/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.7.0/flowbite.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.3.0/chart.min.js"
        integrity="sha512-mlz/Fs1VtBou2TrUkGzX4VoGvybkD9nkeXWJm3rle0DPHssYYx4j+8kIS15T78ttGfmOjH0lLaBXGcShaVkdkg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="../../../CSS/dashboard.css">
    <link rel="icon" href="../../../Image/logo.png">

</head>

<body>


    <?php
      include '../../../Templates/Dashboard/Sidebar.php';
      include '../../../Templates/Dashboard/Navbarprofile2.php';
    ?>


    <div class="flex justify-center items-center mt-4">
        <div
            class="w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">

            <div class="flex flex-col items-center pb-10">

                <img class="mt-4 w-24 h-24 mb-3 rounded-full shadow-lg" src="../../../Image/<?php echo $profile_img2; ?>"
                    alt="Bonnie image" />
                <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">
                    <?php echo $firstname . ' ' . $lastname; ?></h5>
                <span class="text-sm text-gray-500 dark:text-gray-400"><?php echo $email; ?></span>
                <div class="flex mt-4 space-x-3 md:mt-6">

                <form action="../../../Router/Profile/Edit_profile_db.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                            for="file_input">เปลี่ยนรูปโปรไฟล์</label>
                        <input
                            class="block w-full text-20 text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                            id="file_input" type="file" name="profile_img">
                        <div class="mb-8">
                            <label for=""
                                class=" mt-4 block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your
                                email</label>
                            <input type="email" id="email" name="email"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-80 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="อีเมล" required>
                        </div>
                        <div class="mb-8">
                            <label for="" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Firstname</label>
                            <input type="text" id="firstname" name="firstname"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-80 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="ชื่อ" required>
                        </div>
                        <div class="mb-8">
                            <label for="text" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Lastname
                                </label>
                            <input type="text" id="lastname" name="lastname"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-80 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="นามสกุล" required>
                        </div>


                        <button type="submit"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 mx-auto">บันทึก</button>
                    </form>


                </div>
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="../../Javascript/Dashboard/scriptboard.js"></script>
</body>

</html>
