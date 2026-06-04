<?php
require_once 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Ambil data input baru dari form art.php atau writing-detail.php
    $item_id      = isset($_POST['item_id']) ? (int)$_POST['item_id'] : 0;
    $item_type    = isset($_POST['item_type']) ? trim($_POST['item_type']) : '';
    $visitor_name = isset($_POST['visitor_name']) ? trim($_POST['visitor_name']) : '';
    $comment_text = isset($_POST['comment_text']) ? trim($_POST['comment_text']) : '';

    // 2. Validasi sederhana agar tidak ada field yang kosong lolos ke database
    if ($item_id > 0 && !empty($item_type) && !empty($visitor_name) && !empty($comment_text)) {
        try {
            // 3. Sesuaikan query INSERT dengan nama kolom baru di tabel comments kamu
            $sql = "INSERT INTO comments (item_id, item_type, visitor_name, comment_text, created_at) 
                    VALUES (:item_id, :item_type, :visitor_name, :comment_text, NOW())";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'item_id'      => $item_id,
                'item_type'    => $item_type,
                'visitor_name' => $visitor_name,
                'comment_text' => $comment_text
            ]);

            // 4. Redirect kembali ke halaman asal berdasarkan tipenya agar user tidak melihat halaman kosong
            if ($item_type === 'art') {
                header("Location: art.php?status=success");
            } else {
                header("Location: writing-detail.php?id=" . $item_id . "&status=success");
            }
            exit();

        } catch (PDOException $e) {
            // Jika ada error database, cetak error untuk debugging (bisa dihapus jika sudah live)
            die("Gagal menyimpan catatan pikiran: " . $e->getMessage());
        }
    } else {
        die("Mohon isi seluruh baris formulir tanggapan dengan benar.");
    }
} else {
    // Jika diakses langsung tanpa POST method, kembalikan ke index utama
    header("Location: index.php");
    exit();
}