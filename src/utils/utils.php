<?php
//Thêm dấu thập phân và đơn vị tiền tệ
function formatPrice($price)
{
  $newPrice = number_format($price, 0, '', '.');
  return "$newPrice" . "đ";
}
//Định dạng lại ngày
function formatDate($date) {
  $dateObj = date_create($date);
  return date_format($dateObj,"d/m/Y");
}
//Định dạng lại trạng thái
function formatStatus($bool, $mode=null) {
  if($mode == 'user')
    return $bool ? "Đang kích hoạt" : "Tạm khóa";
  else
    return $bool ? "Đang kinh doanh" : "Ngừng kinh doanh";
}
//Định dạng lại 1 số tên
function formatName($col)
{
  $ref = [
    'price' => 'Giá'
  ];
  return $ref[$col];
}
//Định dạng lại tên cột SQL
function formatSQLColumnsName($col)
{
  $ref = [
    //SANPHAM
    'MASP' => 'Mã Sản Phẩm',
    'TENSP' => 'Tên Sản Phẩm',
    'GIA' => 'Giá',
    'MOTA' => 'Mô Tả',
    'SOSAO' => 'Đánh Giá',
    'TENHSX' => 'Tên Hãng',
    'NGSX' => 'Ngày Sản Xuất',
    'KHUYENMAI' => 'Khuyến Mãi (%)',
    'TRANGTHAI' => 'Trạng Thái',
    //HSX
    'MAHSX' => 'Mã HSX',
    'LOGO' => 'Logo',
    //DANHMUC
    'DANHMUC' => 'Danh Mục',
    'MADM' => 'Mã Danh Mục',
    'TENDM' => 'Tên Danh Mục',
    'MAKC' => 'Mã Kích Cỡ',
    'COGIAY' => 'Cỡ Giày',
    'SOLUONG' => 'Số Lượng',
    // HINHANH
    'MAHA' => 'Mã Hình Ảnh',
    'FILE' => 'Hình',
    //HOADON
    'MAHD' => 'Mã Đơn Hàng',
    'MATK' => 'Mã Tài Khoản',
    'TONGTIEN' => 'Tổng Tiền',
    'HOTENKH' => 'Họ Tên',
    'EMAIL' => 'Email',
    'SDT' => 'SĐT',
    'DCHI' => 'Địa Chỉ',
    'GHICHU' => 'Ghi Chú',
    'NGLAPHD' => 'Ngày Lập Hóa Đơn',
    'MATT' => 'Mã Trạng Thái',
    //NGUOIDUNG
    'TENTK' => 'Tên Tài Khoản',
    'HOTEN' => 'Họ Tên',
    'NGLAPTK' => 'Ngày Lập Tài Khoản',
    //TRANGTHAI
    'TENTT' => 'Trạng Thái'
  ];
  return $ref[$col];
}
