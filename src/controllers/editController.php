<?php
require_once("../models/Database.php");
require_once("formValidation.php");
require_once("promptController.php");
require_once("imageController.php");
require_once("../utils/utils.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] != 'POST')
  header("location: ../views/edit.php");

$db = new Database();

switch ($_POST['mode']) {
  case 'info':
    updateInfo();
    break;
  case 'password':
    updatePassword();
    break;
  case 'admin-info':
    updateAdminInfo();
    break;
  case 'admin-password':
    updateAdminPassword();
    break;
  case 'product':
    updateProduct();
    break;
  case 'manufacturer':
    updateManufacturer();
    updateImage();
    break;
  case 'category':
    updateCategory();
    break;
  case 'size':
    updateSize();
    break;
  case 'image':
    updateImage();
    break;
  default:
    errorPrompt(
      'EDIT',
      'Đã xảy ra lỗi, vui lòng thử lại sau!',
      "../admin/edit_admin.php?{$_POST['queryStr']}"
    );
    break;
}

function updateProduct() {
  global $db;
  
  if(empty($_POST['price']) || empty($_POST['discount']) || empty($_POST['rating']))
    errorPrompt(
      'EDIT',
      'Đã có lỗi xảy ra, xin vui lòng thử lại!',
      "../admin/edit_admin.php?{$_POST['queryStr']}"
    );

  if(empty($_POST['date'])) $_POST['date'] = date('Y-m-d');

  $updateProductSQL = "
    update SANPHAM
    set 
      TENSP = '{$_POST['name']}',
      GIA = {$_POST['price']},
      KHUYENMAI = {$_POST['discount']},
      MOTA = '{$_POST['description']}',
      SOSAO = {$_POST['rating']},
      NGSX = '{$_POST['date']}',
      MAHSX = {$_POST['manufacturer']}
    where MASP = {$_POST['id']}
  ";
  if(!$db->query($updateProductSQL))
    errorPrompt(
      'EDIT',
      'Đã có lỗi xảy ra, xin vui lòng thử lại!',
      "../admin/edit_admin.php?{$_POST['queryStr']}"
    );

  $selectCategorizeSQL = "
    select MADM
    from PHANLOAI
    where MASP = {$_POST['id']}
    order by MADM asc
  ";
  $result = $db->query($selectCategorizeSQL);
  
  $currentCategory = [];
  while($row = $db->fetch($result)) {
    $currentCategory[] = $row['MADM'];
  }

  $categoryNeedDeleted = array_diff($currentCategory, $_POST['category']);
  $categoryNeedAdd = array_diff($_POST['category'], $currentCategory);

  foreach($categoryNeedDeleted as $id) {
    $deleteCategorizeSQL = "
      delete from PHANLOAI where MADM = $id
    ";
    if(!$db->query($deleteCategorizeSQL))
      errorPrompt(
        'EDIT',
        'Đã có lỗi xảy ra, xin vui lòng thử lại!',
        "../admin/edit_admin.php?{$_POST['queryStr']}"
      );
  }
  foreach($categoryNeedAdd as $id) {
    $addCategorizeSQL = "
      insert into PHANLOAI(MASP, MADM) values({$_POST['id']}, $id)
    ";
    if(!$db->query($addCategorizeSQL))
      errorPrompt(
        'EDIT',
        'Đã có lỗi xảy ra, xin vui lòng thử lại!',
        "../admin/edit_admin.php?{$_POST['queryStr']}"
      );
  }

  successPrompt(
    'ADMIN_HOMEPAGE',
    'Cập nhật thành công!',
    "../admin/index.php?mode={$_POST['mode']}&page=1"  
  );
}

function updateManufacturer() {
  global $db;

  $updateManufacturerSQL = "
    update HANGSANXUAT
    set TENHSX = '{$_POST['name']}'
    where MAHSX = {$_POST['id']}
  ";

  if($db->query($updateManufacturerSQL))
    successPrompt(
      'ADMIN_HOMEPAGE',
      'Cập nhật thành công!',
      "../admin/index.php?mode={$_POST['mode']}&page=1"  
    );
  else
    errorPrompt(
      'EDIT',
      'Đã có lỗi xảy ra, xin vui lòng thử lại!',
      "../admin/edit_admin.php?{$_POST['queryStr']}"
    );
}

function updateCategory() {
  global $db;

  $updateCategorySQL = "
    update DANHMUC
    set TENDM = '{$_POST['name']}'
    where MADM = {$_POST['id']}
  ";

  if($db->query($updateCategorySQL))
    successPrompt(
      'ADMIN_HOMEPAGE',
      'Cập nhật thành công!',
      "../admin/index.php?mode={$_POST['mode']}&page=1"  
    );
  else
    errorPrompt(
      'EDIT',
      'Đã có lỗi xảy ra, xin vui lòng thử lại!',
      "../admin/edit_admin.php?{$_POST['queryStr']}"
    );
}

function updateSize() {
  global $db;

  $updateSizeSQL = "
    update KICHCO
    set SOLUONG = {$_POST['quantity']}
    where MASP = {$_POST['productId']} and MAKC = {$_POST['id']}
  ";

  if($db->query($updateSizeSQL))
    successPrompt(
      'ADMIN_HOMEPAGE',
      'Cập nhật thành công!',
      "../admin/index.php?mode={$_POST['mode']}&page=1"  
    );
  else
    errorPrompt(
      'EDIT',
      'Đã có lỗi xảy ra, xin vui lòng thử lại!',
      "../admin/edit_admin.php?{$_POST['queryStr']}"
    );
}

function updateImage() {
  global $db;

  $file = $_FILES['image']['tmp_name'];
  $image = file_get_contents($file);

  $stmt = null;

  switch ($_POST['mode']) {
    case 'image':
      $updateImageSQL = "
        update HINHANH
        set FILE = ?
        where MAHA = ? and MASP = ?
      ";
      $stmt = $db->prepare($updateImageSQL);
      mysqli_stmt_bind_param($stmt, 'sii', $image, $_POST['id'], $_POST['productId']);

      if($db->stmt_execute($stmt))
          successPrompt(
            'ADMIN_HOMEPAGE',
            'Cập nhật thành công!',
            "../admin/index.php?mode={$_POST['mode']}&page=1"  
          );
        else
          errorPrompt(
            'EDIT',
            'Đã có lỗi xảy ra, xin vui lòng thử lại!',
            "../admin/edit_admin.php?{$_POST['queryStr']}"
          );

      break;
    case 'manufacturer':
      $updateImageSQL = "
        update HANGSANXUAT
        set LOGO = ?
        where MAHSX = ? 
      ";
      $stmt = $db->prepare($updateImageSQL);
      mysqli_stmt_bind_param($stmt, 'si', $image, $_POST['id']);

      if($db->stmt_execute($stmt))
          successPrompt(
            'ADMIN_HOMEPAGE',
            'Cập nhật thành công!',
            "../admin/index.php?mode={$_POST['mode']}&page=1"  
          );
        else
          errorPrompt(
            'UPLOAD',
            'Đã có lỗi xảy ra, xin vui lòng thử lại!',
            "../admin/edit_admin.php?{$_POST['queryStr']}"
          );

      break;
  }
}

function updateInfo()
{
  global $db;

  $userId = $_SESSION['USER']['INFO']['MATK'];
  $newUsername = $_POST['username'];
  $newFullname = $_POST['fullname'];
  $newEmail = $_POST['email'];
  $newPhone = $_POST['phone'];
  $newAddress = $_POST['address'];

  $updateSql = "
      update NGUOIDUNG
      set 
        TENTK = '$newUsername',
        HOTEN = '$newFullname',
        EMAIL = '$newEmail',
        SDT = '$newPhone',
        DCHI = '$newAddress'
      where MATK = $userId
    ";

  if($db->query($updateSql)) {
    $_SESSION['USER']['INFO'] = $db->fetch($db->query("select MATK, TENTK, HOTEN, EMAIL, SDT, NGLAPTK, DCHI from NGUOIDUNG where MATK = $userId"));
    successPrompt(
      'HOMEPAGE',
      'Cập nhật thành công',
      "../views/user.php"  
    );
  }
  else 
    errorPrompt(
      'EDIT',
      'Đã xảy ra lỗi, vui lòng thử lại sau!',
      "../views/edit.php?{$_POST['queryStr']}"
    );
}

function updatePassword()
{
  global $db;

  $currentPassword = md5($_POST['currentPassword']);
  $newPassword = $_POST['newPassword'];
  $confirmPassword = $_POST['confirmPassword'];

  if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) 
    errorPrompt(
      'EDIT',
      'Vui lòng điền vào biểu mẫu này',
      "../views/edit.php?{$_POST['queryStr']}"
    );
  else {
    $currentUserInfoSQL = "
        select *
        from NGUOIDUNG
        where MATK = {$_SESSION['USER']['INFO']['MATK']}
      ";
    $currentUserInfo = $db->fetch($db->query($currentUserInfoSQL));

    if ($currentUserInfo == 0)
      errorPrompt(
        'EDIT',
        'Mật khẩu không đúng!',
        "../views/edit.php?{$_POST['queryStr']}"  
      );
    else if (!passwordValidation($newPassword))
      errorPrompt(
        'EDIT',
        'Mật Khẩu mới không hợp lệ!',
        "../views/edit.php?{$_POST['queryStr']}"  
      );
    else if ($newPassword != $confirmPassword)
      errorPrompt(
        'EDIT',
        'Mật Khẩu mới không trùng khớp!',
        "../views/edit.php?{$_POST['queryStr']}"  
      );
    else {
      $newPassword = md5($newPassword);
      $updatePassSQL = "
          update NGUOIDUNG
          set MATKHAU = '$newPassword'
          where MATK = {$_SESSION['USER']['INFO']['MATK']}
        ";
      if($db->query($updatePassSQL)) 
        successPrompt(
          'HOMEPAGE',
          'Cập nhật thành công',
          "../views/user.php"  
        );
      else
        errorPrompt(
          'EDIT',
          'Đã xảy ra lỗi, vui lòng thử lại sau!',
          "../views/editphp?{$_POST['queryStr']}"  
        );
    }
  }
}

function updateAdminInfo()
{
  global $db;
  $updateInfoSQL = "
    update QUANTRIVIEN
    set TENTK = '{$_POST['username']}'
    where MAQTV = {$_POST['id']}
  ";
  
  if ($db->query($updateInfoSQL)) {
    $_SESSION['ADMIN']['INFO']['TENTK'] = $_POST['username'];
    successPrompt(
      'ADMIN_HOMEPAGE',
      'Cập nhật thành công',
      "../admin/index.php?mode=admin-info"  
    );
  }
  else 
    errorPrompt(
      'EDIT',
      'Đã xảy ra lỗi, vui lòng thử lại sau!',
      "../admin/edit_admin.php?{$_POST['queryStr']}"
    );
}

function updateAdminPassword()
{
  global $db;

  $currentPassword = md5($_POST['currentPassword']);
  $newPassword = $_POST['newPassword'];
  $confirmPassword = $_POST['confirmPassword'];

  if(empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
    errorPrompt(
      'EDIT',
      'Vui lòng điền vào biểu mẫu này',
      "../admin/edit_admin.php?{$_POST['queryStr']}"
    );
  } else {
    $currentAdminInfoSQL = "
        select *
        from QUANTRIVIEN
        where MAQTV = {$_POST['id']}
      ";
    $adminInfo = $db->fetch($db->query($currentAdminInfoSQL));

    if ($adminInfo == 0)
      errorPrompt(
        'EDIT',
        'Mật khẩu không đúng!',
        "../admin/edit_admin.php?{$_POST['queryStr']}"  
      );
    else if (!passwordValidation($newPassword))
      errorPrompt(
        'EDIT',
        'Mật Khẩu mới không hợp lệ!',
        "../admin/edit_admin.php?{$_POST['queryStr']}"  
      );
    else if ($newPassword != $confirmPassword)
      errorPrompt(
        'EDIT',
        'Mật Khẩu mới không trùng khớp!',
        "../admin/edit_admin.php?{$_POST['queryStr']}"  
      );
    else {
      $newPassword = md5($newPassword);
      $updatePassSQL = "
        update QUANTRIVIEN
        set MATKHAU = '$newPassword'
        where MAQTV = {$adminInfo['MAQTV']}
      ";
      if($db->query($updatePassSQL)) 
        successPrompt(
          'ADMIN_HOMEPAGE',
          'Cập nhật thành công',
          "../admin/index.php?mode=admin-info"  
        );
      else
        errorPrompt(
          'EDIT',
          'Đã xảy ra lỗi, vui lòng thử lại sau!',
          "../admin/edit_admin.php?{$_POST['queryStr']}"  
        );
    }
  }
}
