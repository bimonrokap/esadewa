SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for asset_videos
-- ----------------------------
DROP TABLE IF EXISTS `asset_videos`;
CREATE TABLE `asset_videos`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_asset` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `id_category` int(10) UNSIGNED NOT NULL,
  `file` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `caption` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `created_by` int(10) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for bongkaran_barang_uraians
-- ----------------------------
DROP TABLE IF EXISTS `bongkaran_barang_uraians`;
CREATE TABLE `bongkaran_barang_uraians`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_bongkaran_barang` int(10) NOT NULL,
  `uraian` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` decimal(20, 2) NOT NULL,
  `satuan` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `bongkaran_barang_uraians_ibfk_1`(`id_bongkaran_barang`) USING BTREE,
  CONSTRAINT `bongkaran_barang_uraians_ibfk_1` FOREIGN KEY (`id_bongkaran_barang`) REFERENCES `bongkaran_barangs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for bongkaran_barangs
-- ----------------------------
DROP TABLE IF EXISTS `bongkaran_barangs`;
CREATE TABLE `bongkaran_barangs`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_bongkaran` int(10) NOT NULL,
  `id_asset` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_category_asset` int(10) NOT NULL,
  `nilai_perolehan` double(20, 2) NOT NULL,
  `ord` smallint(3) NOT NULL,
  `luas_bangunan` double(20, 0) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for bongkaran_fotos
-- ----------------------------
DROP TABLE IF EXISTS `bongkaran_fotos`;
CREATE TABLE `bongkaran_fotos`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_bongkaran` int(10) NOT NULL,
  `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for bongkaran_logs
-- ----------------------------
DROP TABLE IF EXISTS `bongkaran_logs`;
CREATE TABLE `bongkaran_logs`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_bongkaran` int(10) NOT NULL,
  `id_status` int(10) NOT NULL,
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_by` int(10) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for bongkarans
-- ----------------------------
DROP TABLE IF EXISTS `bongkarans`;
CREATE TABLE `bongkarans`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `letter_number` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `letter_date` date NOT NULL,
  `perihal` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `penandatangan_surat` smallint(3) NOT NULL,
  `sumber_dana` int(10) NOT NULL,
  `nilai_taksiran` double(20, 0) NOT NULL,
  `surat_pengajuan_satker` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `penetapan_status_penggunaan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kib_bangunan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sk_panitia_bongkaran` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dokumen_penganggaran` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `penetapan_nilai_taksiran` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_bongkaran_status` int(10) NOT NULL,
  `keterangan_veriftk` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `letter_number_banding` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `letter_date_banding` date NULL DEFAULT NULL,
  `perihal_banding` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `penandatangan_surat_banding` smallint(3) NULL DEFAULT NULL,
  `surat_penghantar_banding` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `keterangan_verifadm` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `letter_number_persetujuan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `letter_date_persetujuan` date NULL DEFAULT NULL,
  `perihal_persetujuan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `luas_bangunan_verif` decimal(20, 0) NULL DEFAULT NULL,
  `nilai_taksiran_verif` decimal(20, 0) NULL DEFAULT NULL,
  `surat_persetujuan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `hasil_bongkaran` smallint(3) NULL DEFAULT NULL,
  `nomor_izin_pemusnahan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `tanggal_izin_pemusnahan` date NULL DEFAULT NULL,
  `perihal_pemusnahan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `nomor_berita_acara_pemusnahan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `tanggal_berita_acara_pemusnahan` date NULL DEFAULT NULL,
  `dokumen_persetujuan_pemusnahan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `dokumen_berita_acara_pemusnahan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `nomor_risalah_lelang` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `tanggal_risalah_lelang` date NULL DEFAULT NULL,
  `penandatangan_risalah_lelang` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `nomor_berita_acara` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `tanggal_berita_acara` date NULL DEFAULT NULL,
  `nilai_limit` decimal(20, 0) NULL DEFAULT NULL,
  `nilai_terjual` decimal(20, 0) NULL DEFAULT NULL,
  `dokumen_risalah_lelang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `dokumen_berita_acara` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_by` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for file_tmps
-- ----------------------------
DROP TABLE IF EXISTS `file_tmps`;
CREATE TABLE `file_tmps`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `file` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for image_tmps
-- ----------------------------
DROP TABLE IF EXISTS `image_tmps`;
CREATE TABLE `image_tmps`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `file` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for lapor_bmn_fotos
-- ----------------------------
DROP TABLE IF EXISTS `lapor_bmn_fotos`;
CREATE TABLE `lapor_bmn_fotos`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_lapor_bmn` int(10) NOT NULL,
  `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for lapor_bmn_replies
-- ----------------------------
DROP TABLE IF EXISTS `lapor_bmn_replies`;
CREATE TABLE `lapor_bmn_replies`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_lapor_bmn` int(10) NOT NULL,
  `jawaban` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `file` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_by` int(10) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for lapor_bmns
-- ----------------------------
DROP TABLE IF EXISTS `lapor_bmns`;
CREATE TABLE `lapor_bmns`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_asset` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `id_category_asset` smallint(10) NOT NULL,
  `jenis` smallint(3) NOT NULL,
  `uraian` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `status` smallint(3) NOT NULL,
  `created_by` int(10) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for mapping_assets
-- ----------------------------
DROP TABLE IF EXISTS `mapping_assets`;
CREATE TABLE `mapping_assets`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_category_asset` int(10) UNSIGNED NOT NULL,
  `mapping_asset` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_benda` int(10) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `id_category_asset`(`id_category_asset`, `mapping_asset`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for monitoring_penghapusan_details
-- ----------------------------
DROP TABLE IF EXISTS `monitoring_penghapusan_details`;
CREATE TABLE `monitoring_penghapusan_details`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_monitoring_penghapusan` int(10) NOT NULL,
  `kode_satker` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_satker` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `akun` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `uraian_akun` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_bidang` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `uraian_bidang` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_transaksi` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `uraian_transaksi` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kuantitas` decimal(10, 0) NOT NULL,
  `nilai` decimal(20, 0) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for monitoring_penghapusans
-- ----------------------------
DROP TABLE IF EXISTS `monitoring_penghapusans`;
CREATE TABLE `monitoring_penghapusans`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `year` year NOT NULL,
  `file` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(10) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for monitoring_psps
-- ----------------------------
DROP TABLE IF EXISTS `monitoring_psps`;
CREATE TABLE `monitoring_psps`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `kode_satker` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_category_asset` int(10) NOT NULL,
  `total_unit` int(10) NOT NULL,
  `total_nilai` double(20, 0) NOT NULL,
  `total_unit_psp` int(10) NOT NULL,
  `total_nilai_psp` double(20, 0) NOT NULL,
  `total_unit_belum_psp` int(10) NOT NULL,
  `total_nilai_belum_psp` double(20, 0) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `kode_satker`(`kode_satker`, `id_category_asset`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for pengadaan_logs
-- ----------------------------
DROP TABLE IF EXISTS `pengadaan_logs`;
CREATE TABLE `pengadaan_logs`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_pengadaan` int(10) NOT NULL,
  `id_status` int(10) NOT NULL,
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_by` int(10) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for pengadaan_pembangunan_barangs
-- ----------------------------
DROP TABLE IF EXISTS `pengadaan_pembangunan_barangs`;
CREATE TABLE `pengadaan_pembangunan_barangs`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_pengadaan_pembangunan` int(10) NOT NULL,
  `id_asset` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_category_asset` int(10) NULL DEFAULT NULL,
  `nilai_perolehan` double(20, 2) NOT NULL,
  `ord` smallint(3) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for pengadaan_pembangunan_gambars
-- ----------------------------
DROP TABLE IF EXISTS `pengadaan_pembangunan_gambars`;
CREATE TABLE `pengadaan_pembangunan_gambars`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_pengadaan_pembangunan` int(10) NOT NULL,
  `file` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for pengadaan_pembangunans
-- ----------------------------
DROP TABLE IF EXISTS `pengadaan_pembangunans`;
CREATE TABLE `pengadaan_pembangunans`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_pengadaan` int(10) NOT NULL,
  `jenis_pembangunan` smallint(3) NOT NULL,
  `luas_bangunan` decimal(20, 2) NOT NULL,
  `biaya_fisik` decimal(20, 0) NOT NULL,
  `biaya_perencanaan` decimal(20, 0) NOT NULL,
  `biaya_pengawasan` decimal(20, 0) NOT NULL,
  `biaya_pengelolaan` decimal(20, 0) NOT NULL,
  `pajak_pembangunan` decimal(20, 0) NOT NULL,
  `surat_pengajuan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `surat_psp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `surat_rencana` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `surat_harga_satuan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `surat_analisa` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tor` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for pengadaan_penawaran_fotos
-- ----------------------------
DROP TABLE IF EXISTS `pengadaan_penawaran_fotos`;
CREATE TABLE `pengadaan_penawaran_fotos`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_pengadaan_penawaran` int(10) NOT NULL,
  `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for pengadaan_penawarans
-- ----------------------------
DROP TABLE IF EXISTS `pengadaan_penawarans`;
CREATE TABLE `pengadaan_penawarans`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_pengadaan_tanah` int(10) NOT NULL,
  `harga_penawaran` decimal(20, 0) NOT NULL,
  `luas_tanah` decimal(20, 0) NOT NULL DEFAULT 0,
  `ktp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sertifikat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pajak` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pernyataan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `surat_harga` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `penawaran` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for pengadaan_renovasi_fotos
-- ----------------------------
DROP TABLE IF EXISTS `pengadaan_renovasi_fotos`;
CREATE TABLE `pengadaan_renovasi_fotos`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_pengadaan_renovasi` int(10) NOT NULL,
  `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for pengadaan_renovasi_gambars
-- ----------------------------
DROP TABLE IF EXISTS `pengadaan_renovasi_gambars`;
CREATE TABLE `pengadaan_renovasi_gambars`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_pengadaan_renovasi` int(10) NOT NULL,
  `file` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` smallint(3) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for pengadaan_renovasis
-- ----------------------------
DROP TABLE IF EXISTS `pengadaan_renovasis`;
CREATE TABLE `pengadaan_renovasis`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_pengadaan` int(10) NOT NULL,
  `jenis_pekerjaan` smallint(3) NOT NULL,
  `jenis_barang` smallint(3) NOT NULL,
  `luas_bangunan` decimal(20, 2) NOT NULL,
  `luas_bangunan_rencana` decimal(20, 2) NOT NULL,
  `tingkat_kerusakan` smallint(3) NOT NULL,
  `biaya_fisik` decimal(20, 0) NOT NULL,
  `biaya_perencanaan` decimal(20, 0) NOT NULL,
  `biaya_pengawasan` decimal(20, 0) NOT NULL,
  `biaya_pengelolaan` decimal(20, 0) NOT NULL,
  `pajak_pembangunan` decimal(20, 0) NOT NULL,
  `surat_pengajuan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `surat_psp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `surat_harga` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `analisa_kerusakan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `analisa_pu` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tor` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for pengadaan_tanahs
-- ----------------------------
DROP TABLE IF EXISTS `pengadaan_tanahs`;
CREATE TABLE `pengadaan_tanahs`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_pengadaan` int(10) NOT NULL,
  `tanah_type` smallint(3) NULL DEFAULT NULL,
  `jenis_pengadaan` smallint(3) NOT NULL,
  `tor` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for pengadaans
-- ----------------------------
DROP TABLE IF EXISTS `pengadaans`;
CREATE TABLE `pengadaans`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `letter_number` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `letter_date` date NOT NULL,
  `perihal` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `penandatangan_surat` smallint(3) NOT NULL,
  `id_rkbmn_uraian` int(10) NULL DEFAULT NULL,
  `id_pengadaan_type` int(10) NOT NULL,
  `id_pengadaan_status` int(10) NOT NULL,
  `keterangan_veriftk` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `letter_number_banding` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `letter_date_banding` date NULL DEFAULT NULL,
  `perihal_banding` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `penandatangan_surat_banding` smallint(3) NULL DEFAULT NULL,
  `surat_penghantar_banding` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `keterangan_verifadm` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `letter_number_persetujuan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `letter_date_persetujuan` date NULL DEFAULT NULL,
  `perihal_persetujuan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `surat_persetujuan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_by` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for penghapusan_barangs
-- ----------------------------
DROP TABLE IF EXISTS `penghapusan_barangs`;
CREATE TABLE `penghapusan_barangs`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_penghapusan` int(10) NOT NULL,
  `id_asset` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_category_asset` int(10) NULL DEFAULT NULL,
  `nilai_perolehan` double(20, 2) NOT NULL,
  `ord` smallint(3) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for penghapusan_logs
-- ----------------------------
DROP TABLE IF EXISTS `penghapusan_logs`;
CREATE TABLE `penghapusan_logs`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_penghapusan` int(10) NOT NULL,
  `id_status` int(10) NOT NULL,
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_by` int(10) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for penghapusans
-- ----------------------------
DROP TABLE IF EXISTS `penghapusans`;
CREATE TABLE `penghapusans`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `letter_number` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `letter_date` date NOT NULL,
  `perihal` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `penandatangan_surat` smallint(3) NOT NULL,
  `id_letter_number_penjualan` int(10) NULL DEFAULT NULL,
  `letter_number_penjualan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `letter_date_penjualan` date NULL DEFAULT NULL,
  `perihal_penjualan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `surat_izin_penjualan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `nilai_perolehan` decimal(20, 0) NULL DEFAULT NULL,
  `surat_keterangan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `total_limit` decimal(20, 0) NULL DEFAULT NULL,
  `total_terjual` decimal(20, 0) NOT NULL,
  `risalah_lelang_number` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `risalah_lelang_date` date NOT NULL,
  `penandatangan_risalah` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_berita_acara` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_berita_acara` date NOT NULL,
  `surat_pengajuan_satker` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `daftar_barang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `daftar_barang_rusak` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `risalah_lelang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `surat_berita_acara` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dokumen_lainnya` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `penghapusan_type` smallint(3) NULL DEFAULT NULL,
  `id_penghapusan_status` int(10) NOT NULL,
  `keterangan_veriftk` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `letter_number_banding` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `letter_date_banding` date NULL DEFAULT NULL,
  `perihal_banding` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `penandatangan_surat_banding` smallint(3) NULL DEFAULT NULL,
  `surat_penghantar_banding` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `keterangan_verifadm` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `letter_number_persetujuan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `letter_date_persetujuan` date NULL DEFAULT NULL,
  `perihal_persetujuan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `surat_persetujuan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `jumlah_barang` tinyint(3) NULL DEFAULT NULL,
  `created_by` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for penjualan_barangs
-- ----------------------------
DROP TABLE IF EXISTS `penjualan_barangs`;
CREATE TABLE `penjualan_barangs`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_penjualan` int(10) NOT NULL,
  `id_asset` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_category_asset` int(10) NULL DEFAULT NULL,
  `nilai_perolehan` double(20, 2) NOT NULL,
  `ord` smallint(3) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for penjualan_fotos
-- ----------------------------
DROP TABLE IF EXISTS `penjualan_fotos`;
CREATE TABLE `penjualan_fotos`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_penjualan` int(10) NOT NULL,
  `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for penjualan_logs
-- ----------------------------
DROP TABLE IF EXISTS `penjualan_logs`;
CREATE TABLE `penjualan_logs`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_penjualan` int(10) NOT NULL,
  `id_status` int(10) NOT NULL,
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_by` int(10) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for penjualans
-- ----------------------------
DROP TABLE IF EXISTS `penjualans`;
CREATE TABLE `penjualans`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `letter_number` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `letter_date` date NOT NULL,
  `perihal` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `penandatangan_surat` smallint(3) NOT NULL,
  `total_limit` int(11) NOT NULL,
  `surat_pengajuan_satker` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sk_panitia_penghapusan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ba_hasil` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `daftar_penghentian` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `surat_pernyataan_tanggung` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sk_penetapan_status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `backup_simak` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `id_penjualan_status` int(10) NOT NULL,
  `keterangan_veriftk` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `letter_number_banding` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `letter_date_banding` date NULL DEFAULT NULL,
  `perihal_banding` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `penandatangan_surat_banding` smallint(3) NULL DEFAULT NULL,
  `surat_penghantar_banding` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `keterangan_verifadm` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `letter_number_persetujuan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `letter_date_persetujuan` date NULL DEFAULT NULL,
  `perihal_persetujuan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `surat_persetujuan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_by` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for rkbmn_pemeliharaans
-- ----------------------------
DROP TABLE IF EXISTS `rkbmn_pemeliharaans`;
CREATE TABLE `rkbmn_pemeliharaans`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_rkbmn` int(10) NOT NULL,
  `eselon1` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `draftuapb` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `apip` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `uapb` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `djkn` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `kode_barang` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `nama_barang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `nup` int(3) NULL DEFAULT NULL,
  `tgl_perolehan` datetime(0) NULL DEFAULT NULL,
  `merk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `kondisi` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `status_penggunaan` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `jumlah` int(10) NULL DEFAULT NULL,
  `pemanfaatan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `keb_ril` decimal(20, 0) NULL DEFAULT NULL,
  `nilai_perolehan` decimal(20, 0) NULL DEFAULT NULL,
  `usulan_satker` int(10) NULL DEFAULT NULL,
  `usulan_es1` int(10) NULL DEFAULT NULL,
  `usulan_pb` int(10) NULL DEFAULT NULL,
  `usulan_apip` int(10) NULL DEFAULT NULL,
  `usulan_final` int(10) NULL DEFAULT NULL,
  `koreksi` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `persetujuan_djkn` int(10) NULL DEFAULT NULL,
  `kode_satker` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `nama_satker` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `is_anggaran` tinyint(1) NULL DEFAULT NULL,
  `jumlah_anggaran` decimal(20, 0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for rkbmn_pengadaans
-- ----------------------------
DROP TABLE IF EXISTS `rkbmn_pengadaans`;
CREATE TABLE `rkbmn_pengadaans`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_rkbmn` int(10) NOT NULL,
  `eselon1` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `draftuapb` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `apip` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `uapb` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `djkn` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `no_pengadaan` char(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `no_output` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `kode_barang` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `nama_barang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `kategori` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `sbsk_usulan` decimal(20, 0) NULL DEFAULT NULL,
  `jml_eksisting` decimal(20, 0) NULL DEFAULT NULL,
  `luas_eksisting` decimal(20, 0) NULL DEFAULT NULL,
  `sbsk_eksisting` decimal(20, 0) NULL DEFAULT NULL,
  `optimalisasi` decimal(20, 0) NULL DEFAULT NULL,
  `kebutuhan_ril` decimal(20, 0) NULL DEFAULT NULL,
  `kpb_unit` tinyint(3) NULL DEFAULT NULL,
  `kpb_luas` decimal(20, 0) NULL DEFAULT NULL,
  `eselon_unit` tinyint(3) NULL DEFAULT NULL,
  `eselon_luas` decimal(20, 0) NULL DEFAULT NULL,
  `pengguna_unit` tinyint(3) NULL DEFAULT NULL,
  `pengguna_luas` decimal(20, 0) NULL DEFAULT NULL,
  `apip_unit` tinyint(3) NULL DEFAULT NULL,
  `apip_luas` decimal(20, 0) NULL DEFAULT NULL,
  `final_unit` tinyint(3) NULL DEFAULT NULL,
  `final_luas` decimal(20, 0) NULL DEFAULT NULL,
  `koreksi` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `persetujuan_unit` tinyint(3) NULL DEFAULT NULL,
  `persetujuan_luas` decimal(20, 0) NULL DEFAULT NULL,
  `tahun_anggaran` year NULL DEFAULT NULL,
  `kode_tiket` char(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `kode_satker` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `nama_satker` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `is_anggaran` tinyint(1) NULL DEFAULT NULL,
  `jumlah_anggaran` decimal(20, 0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for rkbmns
-- ----------------------------
DROP TABLE IF EXISTS `rkbmns`;
CREATE TABLE `rkbmns`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `year` year NOT NULL,
  `file` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` smallint(3) NOT NULL,
  `created_by` int(10) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for sertipikasi_tanah_details
-- ----------------------------
DROP TABLE IF EXISTS `sertipikasi_tanah_details`;
CREATE TABLE `sertipikasi_tanah_details`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_sertipikasi_tanah` int(10) NOT NULL,
  `letter_number` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `letter_date` date NOT NULL,
  `perihal` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `catatan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dokumen` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(10) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for sertipikasi_tanahs
-- ----------------------------
DROP TABLE IF EXISTS `sertipikasi_tanahs`;
CREATE TABLE `sertipikasi_tanahs`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_tanah` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_satker` int(10) NOT NULL,
  `jumlah_anggaran` double(20, 0) NOT NULL,
  `status` smallint(3) NOT NULL DEFAULT 1,
  `progress` smallint(3) NOT NULL DEFAULT 0,
  `tanggal_tindak_lanjut` datetime(0) NULL DEFAULT NULL,
  `created_by` int(10) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for sewa_barangs
-- ----------------------------
DROP TABLE IF EXISTS `sewa_barangs`;
CREATE TABLE `sewa_barangs`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_sewa` int(10) NOT NULL,
  `id_asset` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_category_asset` int(10) NULL DEFAULT NULL,
  `nilai_perolehan` double(20, 2) NOT NULL,
  `ord` smallint(3) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for sewa_categories
-- ----------------------------
DROP TABLE IF EXISTS `sewa_categories`;
CREATE TABLE `sewa_categories`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_sewa` int(10) NOT NULL,
  `id_category_asset` int(10) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for sewa_fotos
-- ----------------------------
DROP TABLE IF EXISTS `sewa_fotos`;
CREATE TABLE `sewa_fotos`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_sewa` int(10) NOT NULL,
  `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for sewa_logs
-- ----------------------------
DROP TABLE IF EXISTS `sewa_logs`;
CREATE TABLE `sewa_logs`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_sewa` int(10) NOT NULL,
  `id_status` int(10) NOT NULL,
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_by` int(10) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for sewas
-- ----------------------------
DROP TABLE IF EXISTS `sewas`;
CREATE TABLE `sewas`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `letter_number` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `letter_date` date NOT NULL,
  `perihal` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `penandatangan_surat` smallint(3) NOT NULL,
  `no_surat_persetujuan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_surat_persetujuan` date NOT NULL,
  `perihal_surat_persetujuan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `penandatangan_persetujuan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `periode` smallint(3) NOT NULL,
  `nilai_sewa` double(20, 0) NOT NULL,
  `identitas_penyewa` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lokasi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `luas_asset` double(20, 2) NULL DEFAULT NULL,
  `surat_pengajuan_satker` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `surat_rekomendasi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `id_sewa_status` int(10) NULL DEFAULT NULL,
  `keterangan_veriftk` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `letter_number_banding` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `letter_date_banding` date NULL DEFAULT NULL,
  `perihal_banding` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `penandatangan_surat_banding` smallint(3) NULL DEFAULT NULL,
  `surat_penghantar_banding` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `keterangan_verifadm` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `letter_number_persetujuan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `letter_date_persetujuan` date NULL DEFAULT NULL,
  `perihal_persetujuan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `surat_persetujuan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `tanggal_pembayaran` date NULL DEFAULT NULL,
  `akun_pembayaran` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `nomor_ntb` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `nomor_ntpn` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `jumlah_pembayaran` decimal(20, 0) NULL DEFAULT NULL,
  `bukti_pembayaran` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `nomor_perjanjian` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `tanggal_perjanjian` date NULL DEFAULT NULL,
  `periode_perjanjian` smallint(3) NULL DEFAULT NULL,
  `tanggal_jatuh_tempo` date NULL DEFAULT NULL,
  `nilai_perjanjian_sewa` decimal(20, 0) NULL DEFAULT NULL,
  `surat_perjanjian_sewa` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_by` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tingkat_bandings
-- ----------------------------
DROP TABLE IF EXISTS `tingkat_bandings`;
CREATE TABLE `tingkat_bandings`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_wilayah` int(10) NOT NULL,
  `lingkungan` enum('PN','PA','PMT','PM','PT') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_satker` int(10) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `kode`(`id_satker`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- View structure for view_barang
-- ----------------------------
DROP VIEW IF EXISTS `view_barang`;
CREATE ALGORITHM = UNDEFINED DEFINER = `sipermari`@`localhost` SQL SECURITY DEFINER VIEW `view_barang` AS select `asset_tanahs`.`id` AS `id`,concat_ws('-',`asset_tanahs`.`kode_satker`,`asset_tanahs`.`kode_barang`,`asset_tanahs`.`nup`) AS `id_asset`,`asset_tanahs`.`kode_satker` AS `kode_satker`,`asset_tanahs`.`nama_barang` AS `nama_barang`,`asset_tanahs`.`kode_barang` AS `kode_barang`,`asset_tanahs`.`nup` AS `nup`,`asset_tanahs`.`nilai_perolehan` AS `nilai_perolehan`,3 AS `category` from `asset_tanahs` union all select `asset_alat_bermotors`.`id` AS `id`,concat_ws('-',`asset_alat_bermotors`.`kode_satker`,`asset_alat_bermotors`.`kode_barang`,`asset_alat_bermotors`.`nup`) AS `id_asset`,`asset_alat_bermotors`.`kode_satker` AS `kode_satker`,`asset_alat_bermotors`.`nama_barang` AS `nama_barang`,`asset_alat_bermotors`.`kode_barang` AS `kode_barang`,`asset_alat_bermotors`.`nup` AS `nup`,`asset_alat_bermotors`.`nilai_perolehan` AS `nilai_perolehan`,4 AS `category` from `asset_alat_bermotors` union all select `asset_peralatan_non_tiks`.`id` AS `id`,concat_ws('-',`asset_peralatan_non_tiks`.`kode_satker`,`asset_peralatan_non_tiks`.`kode_barang`,`asset_peralatan_non_tiks`.`nup`) AS `id_asset`,`asset_peralatan_non_tiks`.`kode_satker` AS `kode_satker`,`asset_peralatan_non_tiks`.`nama_barang` AS `nama_barang`,`asset_peralatan_non_tiks`.`kode_barang` AS `kode_barang`,`asset_peralatan_non_tiks`.`nup` AS `nup`,`asset_peralatan_non_tiks`.`nilai_perolehan` AS `nilai_perolehan`,5 AS `category` from `asset_peralatan_non_tiks` union all select `asset_peralatan_khusus_tiks`.`id` AS `id`,concat_ws('-',`asset_peralatan_khusus_tiks`.`kode_satker`,`asset_peralatan_khusus_tiks`.`kode_barang`,`asset_peralatan_khusus_tiks`.`nup`) AS `id_asset`,`asset_peralatan_khusus_tiks`.`kode_satker` AS `kode_satker`,`asset_peralatan_khusus_tiks`.`nama_barang` AS `nama_barang`,`asset_peralatan_khusus_tiks`.`kode_barang` AS `kode_barang`,`asset_peralatan_khusus_tiks`.`nup` AS `nup`,`asset_peralatan_khusus_tiks`.`nilai_perolehan` AS `nilai_perolehan`,6 AS `category` from `asset_peralatan_khusus_tiks` union all select `asset_alat_berats`.`id` AS `id`,concat_ws('-',`asset_alat_berats`.`kode_satker`,`asset_alat_berats`.`kode_barang`,`asset_alat_berats`.`nup`) AS `id_asset`,`asset_alat_berats`.`kode_satker` AS `kode_satker`,`asset_alat_berats`.`nama_barang` AS `nama_barang`,`asset_alat_berats`.`kode_barang` AS `kode_barang`,`asset_alat_berats`.`nup` AS `nup`,`asset_alat_berats`.`nilai_perolehan` AS `nilai_perolehan`,7 AS `category` from `asset_alat_berats` union all select `asset_bangunan_gedungs`.`id` AS `id`,concat_ws('-',`asset_bangunan_gedungs`.`kode_satker`,`asset_bangunan_gedungs`.`kode_barang`,`asset_bangunan_gedungs`.`nup`) AS `id_asset`,`asset_bangunan_gedungs`.`kode_satker` AS `kode_satker`,`asset_bangunan_gedungs`.`nama_barang` AS `nama_barang`,`asset_bangunan_gedungs`.`kode_barang` AS `kode_barang`,`asset_bangunan_gedungs`.`nup` AS `nup`,`asset_bangunan_gedungs`.`nilai_perolehan` AS `nilai_perolehan`,9 AS `category` from `asset_bangunan_gedungs` union all select `asset_rumah_negaras`.`id` AS `id`,concat_ws('-',`asset_rumah_negaras`.`kode_satker`,`asset_rumah_negaras`.`kode_barang`,`asset_rumah_negaras`.`nup`) AS `id_asset`,`asset_rumah_negaras`.`kode_satker` AS `kode_satker`,`asset_rumah_negaras`.`nama_barang` AS `nama_barang`,`asset_rumah_negaras`.`kode_barang` AS `kode_barang`,`asset_rumah_negaras`.`nup` AS `nup`,`asset_rumah_negaras`.`nilai_perolehan` AS `nilai_perolehan`,10 AS `category` from `asset_rumah_negaras` union all select `asset_jalan_jembatans`.`id` AS `id`,concat_ws('-',`asset_jalan_jembatans`.`kode_satker`,`asset_jalan_jembatans`.`kode_barang`,`asset_jalan_jembatans`.`nup`) AS `id_asset`,`asset_jalan_jembatans`.`kode_satker` AS `kode_satker`,`asset_jalan_jembatans`.`nama_barang` AS `nama_barang`,`asset_jalan_jembatans`.`kode_barang` AS `kode_barang`,`asset_jalan_jembatans`.`nup` AS `nup`,`asset_jalan_jembatans`.`nilai_perolehan` AS `nilai_perolehan`,11 AS `category` from `asset_jalan_jembatans` union all select `asset_air_irigasis`.`id` AS `id`,concat_ws('-',`asset_air_irigasis`.`kode_satker`,`asset_air_irigasis`.`kode_barang`,`asset_air_irigasis`.`nup`) AS `id_asset`,`asset_air_irigasis`.`kode_satker` AS `kode_satker`,`asset_air_irigasis`.`nama_barang` AS `nama_barang`,`asset_air_irigasis`.`kode_barang` AS `kode_barang`,`asset_air_irigasis`.`nup` AS `nup`,`asset_air_irigasis`.`nilai_perolehan` AS `nilai_perolehan`,12 AS `category` from `asset_air_irigasis` union all select `asset_instalasi_jaringans`.`id` AS `id`,concat_ws('-',`asset_instalasi_jaringans`.`kode_satker`,`asset_instalasi_jaringans`.`kode_barang`,`asset_instalasi_jaringans`.`nup`) AS `id_asset`,`asset_instalasi_jaringans`.`kode_satker` AS `kode_satker`,`asset_instalasi_jaringans`.`nama_barang` AS `nama_barang`,`asset_instalasi_jaringans`.`kode_barang` AS `kode_barang`,`asset_instalasi_jaringans`.`nup` AS `nup`,`asset_instalasi_jaringans`.`nilai_perolehan` AS `nilai_perolehan`,13 AS `category` from `asset_instalasi_jaringans` union all select `asset_tetap_lainnyas`.`id` AS `id`,concat_ws('-',`asset_tetap_lainnyas`.`kode_satker`,`asset_tetap_lainnyas`.`kode_barang`,`asset_tetap_lainnyas`.`nup`) AS `id_asset`,`asset_tetap_lainnyas`.`kode_satker` AS `kode_satker`,`asset_tetap_lainnyas`.`nama_barang` AS `nama_barang`,`asset_tetap_lainnyas`.`kode_barang` AS `kode_barang`,`asset_tetap_lainnyas`.`nup` AS `nup`,`asset_tetap_lainnyas`.`nilai_perolehan` AS `nilai_perolehan`,14 AS `category` from `asset_tetap_lainnyas` union all select `asset_tak_berwujuds`.`id` AS `id`,concat_ws('-',`asset_tak_berwujuds`.`kode_satker`,`asset_tak_berwujuds`.`kode_barang`,`asset_tak_berwujuds`.`nup`) AS `id_asset`,`asset_tak_berwujuds`.`kode_satker` AS `kode_satker`,`asset_tak_berwujuds`.`nama_barang` AS `nama_barang`,`asset_tak_berwujuds`.`kode_barang` AS `kode_barang`,`asset_tak_berwujuds`.`nup` AS `nup`,`asset_tak_berwujuds`.`nilai_perolehan` AS `nilai_perolehan`,15 AS `category` from `asset_tak_berwujuds` union all select `asset_renovasis`.`id` AS `id`,concat_ws('-',`asset_renovasis`.`kode_satker`,`asset_renovasis`.`kode_barang`,`asset_renovasis`.`nup`) AS `id_asset`,`asset_renovasis`.`kode_satker` AS `kode_satker`,`asset_renovasis`.`nama_barang` AS `nama_barang`,`asset_renovasis`.`kode_barang` AS `kode_barang`,`asset_renovasis`.`nup` AS `nup`,`asset_renovasis`.`nilai_perolehan` AS `nilai_perolehan`,16 AS `category` from `asset_renovasis` union all select `asset_konstruksi_dalam_pengerjaans`.`id` AS `id`,concat_ws('-',`asset_konstruksi_dalam_pengerjaans`.`kode_satker`,`asset_konstruksi_dalam_pengerjaans`.`kode_barang`,`asset_konstruksi_dalam_pengerjaans`.`nup`) AS `id_asset`,`asset_konstruksi_dalam_pengerjaans`.`kode_satker` AS `kode_satker`,`asset_konstruksi_dalam_pengerjaans`.`nama_barang` AS `nama_barang`,`asset_konstruksi_dalam_pengerjaans`.`kode_barang` AS `kode_barang`,`asset_konstruksi_dalam_pengerjaans`.`nup` AS `nup`,`asset_konstruksi_dalam_pengerjaans`.`nilai_perolehan` AS `nilai_perolehan`,17 AS `category` from `asset_konstruksi_dalam_pengerjaans`;

-- ----------------------------
-- View structure for view_total_psp
-- ----------------------------
DROP VIEW IF EXISTS `view_total_psp`;
CREATE ALGORITHM = UNDEFINED DEFINER = `sipermari`@`localhost` SQL SECURITY DEFINER VIEW `view_total_psp` AS select count(0) AS `jumlah`,12 AS `category` from `asset_air_irigasis` where (`asset_air_irigasis`.`tgl_psp` is not null) union all select count(0) AS `jumlah`,7 AS `category` from `asset_alat_berats` where (`asset_alat_berats`.`tgl_psp` is not null) union all select count(0) AS `jumlah`,4 AS `category` from `asset_alat_bermotors` where (`asset_alat_bermotors`.`tgl_psp` is not null) union all select count(0) AS `jumlah`,9 AS `category` from `asset_bangunan_gedungs` where (`asset_bangunan_gedungs`.`tgl_psp` is not null) union all select count(0) AS `jumlah`,13 AS `category` from `asset_instalasi_jaringans` where (`asset_instalasi_jaringans`.`tgl_psp` is not null) union all select count(0) AS `jumlah`,11 AS `category` from `asset_jalan_jembatans` where (`asset_jalan_jembatans`.`tgl_psp` is not null) union all select count(0) AS `jumlah`,17 AS `category` from `asset_konstruksi_dalam_pengerjaans` where (`asset_konstruksi_dalam_pengerjaans`.`tgl_psp` is not null) union all select count(0) AS `jumlah`,6 AS `category` from `asset_peralatan_khusus_tiks` where (`asset_peralatan_khusus_tiks`.`tgl_psp` is not null) union all select count(0) AS `jumlah`,5 AS `category` from `asset_peralatan_non_tiks` where (`asset_peralatan_non_tiks`.`tgl_psp` is not null) union all select count(0) AS `jumlah`,10 AS `category` from `asset_rumah_negaras` where (`asset_rumah_negaras`.`tgl_psp` is not null) union all select count(0) AS `jumlah`,15 AS `category` from `asset_tak_berwujuds` where (`asset_tak_berwujuds`.`tgl_psp` is not null) union all select count(0) AS `jumlah`,3 AS `category` from `asset_tanahs` where (`asset_tanahs`.`tgl_psp` is not null) union all select count(0) AS `jumlah`,14 AS `category` from `asset_tetap_lainnyas` where (`asset_tetap_lainnyas`.`tgl_psp` is not null);

-- ----------------------------
-- Table structure for bongkaran_statuses
-- ----------------------------
DROP TABLE IF EXISTS `bongkaran_statuses`;
CREATE TABLE `bongkaran_statuses`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `state` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of bongkaran_statuses
-- ----------------------------
INSERT INTO `bongkaran_statuses` VALUES (1, 'Permohonan Oleh Satker', 'warning');
INSERT INTO `bongkaran_statuses` VALUES (2, 'Permohonan oleh Tingkat Banding', 'info');
INSERT INTO `bongkaran_statuses` VALUES (3, 'Permohonan dikembalikan ke Satker', 'danger');
INSERT INTO `bongkaran_statuses` VALUES (4, 'Pengajuan Diterima', 'focus');
INSERT INTO `bongkaran_statuses` VALUES (5, 'Permohonan dikembalikan ke Tingkat Banding', 'danger');
INSERT INTO `bongkaran_statuses` VALUES (6, 'Permohonan Diproses', 'accent');
INSERT INTO `bongkaran_statuses` VALUES (7, 'Permohonan Selesai', 'success');
INSERT INTO `bongkaran_statuses` VALUES (8, 'Ubah Permohonan', 'secondary');
INSERT INTO `bongkaran_statuses` VALUES (9, 'Menunggu Hasil Bongkaran', 'info');

-- ----------------------------
-- Table structure for bongkaran_sumber_danas
-- ----------------------------
DROP TABLE IF EXISTS `bongkaran_sumber_danas`;
CREATE TABLE `bongkaran_sumber_danas`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of bongkaran_sumber_danas
-- ----------------------------
INSERT INTO `bongkaran_sumber_danas` VALUES (1, 'DIPA', NULL, NULL);
INSERT INTO `bongkaran_sumber_danas` VALUES (2, 'Non DIPA', NULL, NULL);

-- ----------------------------
-- Table structure for doc_template_histories
-- ----------------------------
DROP TABLE IF EXISTS `doc_template_histories`;
CREATE TABLE `doc_template_histories`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_doc_template` int(10) NOT NULL,
  `version` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `file` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_by` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of doc_template_histories
-- ----------------------------
INSERT INTO `doc_template_histories` VALUES (1, 1, 'Versi 1', '1619688515-draft-persetujuan-penjualan-bongkaran-versi-1.docx', 1, '2018-08-21 12:14:02', '2021-04-29 16:28:35');
INSERT INTO `doc_template_histories` VALUES (2, 2, 'Versi 1', '1616420840-draft-memorandum-persetujuan-penjualan-bongkaran-versi-1.docx', 1, '2021-03-10 16:24:18', '2021-03-22 20:47:20');
INSERT INTO `doc_template_histories` VALUES (3, 3, 'Versi 1', '1616420782-draft-sk-sewa-versi-1.docx', 1, '2021-03-14 20:53:34', '2021-03-22 20:46:22');
INSERT INTO `doc_template_histories` VALUES (4, 4, 'Versi 1', '1616420815-draft-memorandum-sk-sewa-versi-1.docx', 1, '2021-03-14 21:20:01', '2021-03-22 20:46:55');
INSERT INTO `doc_template_histories` VALUES (5, 5, 'Versi 1', '1616420798-draft-sk-penghapusan-versi-1.docx', 1, '2021-03-14 22:19:39', '2021-03-22 20:46:38');
INSERT INTO `doc_template_histories` VALUES (6, 6, 'Versi 1', '1616420828-draft-memorandum-sk-penghapusan-versi-1.docx', 1, '2021-03-14 22:45:58', '2021-03-22 20:47:08');
INSERT INTO `doc_template_histories` VALUES (7, 7, 'Versi 1', '1619777042-draft-persetujuan-penjualan-versi-1.docx', 1, '2021-03-22 20:44:55', '2021-04-30 17:04:02');
INSERT INTO `doc_template_histories` VALUES (8, 8, 'Versi 1', '1619778598-draft-memorandum-persetujuan-penjualan-versi-1.docx', 1, '2021-03-22 20:45:17', '2021-04-30 17:29:58');

-- ----------------------------
-- Table structure for doc_template_params
-- ----------------------------
DROP TABLE IF EXISTS `doc_template_params`;
CREATE TABLE `doc_template_params`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_doc_template` int(10) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `value` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `id_doc_template`(`id_doc_template`, `name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 98 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of doc_template_params
-- ----------------------------
INSERT INTO `doc_template_params` VALUES (1, 1, 'satker_name', NULL);
INSERT INTO `doc_template_params` VALUES (2, 1, 'tingkat_banding_name', NULL);
INSERT INTO `doc_template_params` VALUES (3, 1, 'tingkat_banding_city', NULL);
INSERT INTO `doc_template_params` VALUES (4, 1, 'penandatangan_tingkat_banding', NULL);
INSERT INTO `doc_template_params` VALUES (5, 1, 'no_surat_banding', NULL);
INSERT INTO `doc_template_params` VALUES (6, 1, 'tanggal_surat_banding', NULL);
INSERT INTO `doc_template_params` VALUES (7, 1, 'perihal_surat_banding', NULL);
INSERT INTO `doc_template_params` VALUES (8, 1, 'nilai_perolehan', NULL);
INSERT INTO `doc_template_params` VALUES (9, 1, 'nilai_perolehan_terbilang', NULL);
INSERT INTO `doc_template_params` VALUES (10, 1, 'nilai_limit', NULL);
INSERT INTO `doc_template_params` VALUES (11, 1, 'nilai_limit_terbilang', NULL);
INSERT INTO `doc_template_params` VALUES (12, 1, 'dirjen', NULL);
INSERT INTO `doc_template_params` VALUES (13, 1, 'kanwil_djkn', NULL);
INSERT INTO `doc_template_params` VALUES (14, 1, 'kpknl', NULL);
INSERT INTO `doc_template_params` VALUES (15, 2, 'satker_name', NULL);
INSERT INTO `doc_template_params` VALUES (16, 2, 'tingkat_banding_name', NULL);
INSERT INTO `doc_template_params` VALUES (17, 2, 'penandatangan_tingkat_banding', NULL);
INSERT INTO `doc_template_params` VALUES (18, 2, 'no_surat_banding', NULL);
INSERT INTO `doc_template_params` VALUES (19, 2, 'tanggal_surat_banding', NULL);
INSERT INTO `doc_template_params` VALUES (20, 2, 'perihal_surat_banding', NULL);
INSERT INTO `doc_template_params` VALUES (21, 2, 'nilai_limit', NULL);
INSERT INTO `doc_template_params` VALUES (22, 2, 'nilai_limit_terbilang', NULL);
INSERT INTO `doc_template_params` VALUES (23, 3, 'kanwil_djkn', NULL);
INSERT INTO `doc_template_params` VALUES (24, 3, 'kpknl', NULL);
INSERT INTO `doc_template_params` VALUES (25, 3, 'satker_name', NULL);
INSERT INTO `doc_template_params` VALUES (26, 3, 'no_surat_kpknl', NULL);
INSERT INTO `doc_template_params` VALUES (27, 3, 'tanggal_surat_kpknl', NULL);
INSERT INTO `doc_template_params` VALUES (28, 3, 'perihal_surat_kpknl', NULL);
INSERT INTO `doc_template_params` VALUES (29, 3, 'identitas_penyewa', NULL);
INSERT INTO `doc_template_params` VALUES (30, 3, 'dirjen', NULL);
INSERT INTO `doc_template_params` VALUES (31, 3, 'tingkat_banding_name', NULL);
INSERT INTO `doc_template_params` VALUES (32, 4, 'tingkat_banding_name', NULL);
INSERT INTO `doc_template_params` VALUES (33, 4, 'penandatangan_tingkat_banding', NULL);
INSERT INTO `doc_template_params` VALUES (34, 4, 'no_surat_banding', NULL);
INSERT INTO `doc_template_params` VALUES (35, 4, 'tanggal_surat_banding', NULL);
INSERT INTO `doc_template_params` VALUES (36, 4, 'perihal_surat_banding', NULL);
INSERT INTO `doc_template_params` VALUES (37, 4, 'satker_name', NULL);
INSERT INTO `doc_template_params` VALUES (38, 5, 'satker_name', NULL);
INSERT INTO `doc_template_params` VALUES (39, 5, 'penandatangan_tingkat_banding', NULL);
INSERT INTO `doc_template_params` VALUES (40, 5, 'no_surat_banding', NULL);
INSERT INTO `doc_template_params` VALUES (41, 5, 'tanggal_surat_banding', NULL);
INSERT INTO `doc_template_params` VALUES (42, 5, 'perihal_surat_banding', NULL);
INSERT INTO `doc_template_params` VALUES (43, 5, 'no_surat_persetujuan', NULL);
INSERT INTO `doc_template_params` VALUES (44, 5, 'tanggal_surat_persetujuan', NULL);
INSERT INTO `doc_template_params` VALUES (45, 5, 'perihal_surat_persetujuan', NULL);
INSERT INTO `doc_template_params` VALUES (46, 5, 'no_risalah_lelang', NULL);
INSERT INTO `doc_template_params` VALUES (47, 5, 'tanggal_risalah_lelang', NULL);
INSERT INTO `doc_template_params` VALUES (48, 5, 'no_bast', NULL);
INSERT INTO `doc_template_params` VALUES (49, 5, 'tanggal_bast', NULL);
INSERT INTO `doc_template_params` VALUES (50, 5, 'dirjen', NULL);
INSERT INTO `doc_template_params` VALUES (51, 5, 'kanwil_djkn', NULL);
INSERT INTO `doc_template_params` VALUES (52, 6, 'penandatangan_tingkat_banding', NULL);
INSERT INTO `doc_template_params` VALUES (53, 6, 'no_surat_banding', NULL);
INSERT INTO `doc_template_params` VALUES (54, 6, 'tanggal_surat_banding', NULL);
INSERT INTO `doc_template_params` VALUES (55, 6, 'perihal_surat_banding', NULL);
INSERT INTO `doc_template_params` VALUES (56, 6, 'satker_name', NULL);
INSERT INTO `doc_template_params` VALUES (57, 6, 'no_surat_persetujuan', NULL);
INSERT INTO `doc_template_params` VALUES (58, 6, 'tanggal_surat_persetujuan', NULL);
INSERT INTO `doc_template_params` VALUES (59, 3, 'no_surat_persetujuan', NULL);
INSERT INTO `doc_template_params` VALUES (60, 3, 'tanggal_surat_persetujuan', NULL);
INSERT INTO `doc_template_params` VALUES (61, 3, 'perihal_surat_persetujuan', NULL);
INSERT INTO `doc_template_params` VALUES (62, 5, 'jenis_bmn', NULL);
INSERT INTO `doc_template_params` VALUES (63, 5, 'total_nilai_terjual', NULL);
INSERT INTO `doc_template_params` VALUES (64, 5, 'total_nilai_terjual_terbilang', NULL);
INSERT INTO `doc_template_params` VALUES (65, 5, 'jenis_bmn_upper', NULL);
INSERT INTO `doc_template_params` VALUES (66, 5, 'satker_name_upper', NULL);
INSERT INTO `doc_template_params` VALUES (67, 3, 'satker_name_upper', NULL);
INSERT INTO `doc_template_params` VALUES (70, 5, 'tingkat_banding_name', NULL);
INSERT INTO `doc_template_params` VALUES (71, 5, 'kpknl', NULL);
INSERT INTO `doc_template_params` VALUES (72, 6, 'jenis_bmn', NULL);
INSERT INTO `doc_template_params` VALUES (73, 6, 'jenis_bmn_upper', NULL);
INSERT INTO `doc_template_params` VALUES (74, 7, 'dirjen', NULL);
INSERT INTO `doc_template_params` VALUES (75, 7, 'kanwil_djkn', NULL);
INSERT INTO `doc_template_params` VALUES (76, 7, 'kpknl', NULL);
INSERT INTO `doc_template_params` VALUES (77, 7, 'nilai_limit', NULL);
INSERT INTO `doc_template_params` VALUES (78, 7, 'nilai_limit_terbilang', NULL);
INSERT INTO `doc_template_params` VALUES (79, 7, 'nilai_perolehan', NULL);
INSERT INTO `doc_template_params` VALUES (80, 7, 'nilai_perolehan_terbilang', NULL);
INSERT INTO `doc_template_params` VALUES (81, 7, 'no_surat_banding', NULL);
INSERT INTO `doc_template_params` VALUES (82, 7, 'penandatangan_tingkat_banding', NULL);
INSERT INTO `doc_template_params` VALUES (83, 7, 'perihal_surat_banding', NULL);
INSERT INTO `doc_template_params` VALUES (84, 7, 'satker_name', NULL);
INSERT INTO `doc_template_params` VALUES (85, 7, 'tanggal_surat_banding', NULL);
INSERT INTO `doc_template_params` VALUES (86, 7, 'tingkat_banding_city', NULL);
INSERT INTO `doc_template_params` VALUES (87, 7, 'tingkat_banding_name', NULL);
INSERT INTO `doc_template_params` VALUES (88, 8, 'nilai_limit', NULL);
INSERT INTO `doc_template_params` VALUES (89, 8, 'nilai_limit_terbilang', NULL);
INSERT INTO `doc_template_params` VALUES (90, 8, 'no_surat_banding', NULL);
INSERT INTO `doc_template_params` VALUES (91, 8, 'penandatangan_tingkat_banding', NULL);
INSERT INTO `doc_template_params` VALUES (92, 8, 'perihal_surat_banding', NULL);
INSERT INTO `doc_template_params` VALUES (93, 8, 'satker_name', NULL);
INSERT INTO `doc_template_params` VALUES (94, 8, 'tanggal_surat_banding', NULL);
INSERT INTO `doc_template_params` VALUES (95, 8, 'tingkat_banding_name', NULL);
INSERT INTO `doc_template_params` VALUES (96, 8, 'nilai_perolehan', NULL);
INSERT INTO `doc_template_params` VALUES (97, 8, 'nilai_perolehan_terbilang', NULL);

-- ----------------------------
-- Table structure for doc_templates
-- ----------------------------
DROP TABLE IF EXISTS `doc_templates`;
CREATE TABLE `doc_templates`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_default_doc_template_history` int(10) NULL DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of doc_templates
-- ----------------------------
INSERT INTO `doc_templates` VALUES (1, 1, 'Draft Persetujuan Penjualan Bongkaran', 'doc-pengelolaan-bongkaran-persetujuan');
INSERT INTO `doc_templates` VALUES (2, 2, 'Draft Memorandum Persetujuan Penjualan Bongkaran', 'doc-pengelolaan-bongkaran-memorandum-persetujuan');
INSERT INTO `doc_templates` VALUES (3, 3, 'Draft SK Sewa', 'doc-pengelolaan-sewa-sk');
INSERT INTO `doc_templates` VALUES (4, 4, 'Draft Memorandum SK Sewa', 'doc-pengelolaan-sewa-memorandum');
INSERT INTO `doc_templates` VALUES (5, 5, 'Draft SK Penghapusan', 'doc-pengelolaan-penghapusan-sk');
INSERT INTO `doc_templates` VALUES (6, 6, 'Draft Memorandum SK Penghapusan', 'doc-pengelolaan-penghapusan-memorandum');
INSERT INTO `doc_templates` VALUES (7, 7, 'Draft Persetujuan Penjualan', 'doc-pengelolaan-penjualan-persetujuan');
INSERT INTO `doc_templates` VALUES (8, 8, 'Draft Memorandum Persetujuan Penjualan', 'doc-pengelolaan-penjualan-memorandum');

-- ----------------------------
-- Table structure for interconnection_configs
-- ----------------------------
DROP TABLE IF EXISTS `interconnection_configs`;
CREATE TABLE `interconnection_configs`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of interconnection_configs
-- ----------------------------
INSERT INTO `interconnection_configs` VALUES (1, 'last_check', '2021-08-23 23:10:21', NULL, '2021-08-23 23:10:21');
INSERT INTO `interconnection_configs` VALUES (2, 'next_check', '2021-08-30 00:10:00', NULL, '2021-08-23 23:10:10');
INSERT INTO `interconnection_configs` VALUES (3, 'status', 'online', NULL, NULL);
INSERT INTO `interconnection_configs` VALUES (4, 'last_update', '2021-06-20 09:13:22', NULL, '2021-08-23 23:10:21');
INSERT INTO `interconnection_configs` VALUES (5, 'last_status', '200', NULL, '2021-08-23 23:10:21');

-- ----------------------------
-- Table structure for penandatangan_surats
-- ----------------------------
DROP TABLE IF EXISTS `penandatangan_surats`;
CREATE TABLE `penandatangan_surats`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of penandatangan_surats
-- ----------------------------
INSERT INTO `penandatangan_surats` VALUES (1, 'Sekertaris', NULL, NULL);
INSERT INTO `penandatangan_surats` VALUES (2, 'Ketua', NULL, NULL);
INSERT INTO `penandatangan_surats` VALUES (3, 'Wakil Ketua', NULL, NULL);

-- ----------------------------
-- Table structure for pengadaan_statuses
-- ----------------------------
DROP TABLE IF EXISTS `pengadaan_statuses`;
CREATE TABLE `pengadaan_statuses`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `state` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pengadaan_statuses
-- ----------------------------
INSERT INTO `pengadaan_statuses` VALUES (1, 'Permohonan Oleh Satker', 'warning');
INSERT INTO `pengadaan_statuses` VALUES (2, 'Permohonan oleh Tingkat Banding', 'info');
INSERT INTO `pengadaan_statuses` VALUES (3, 'Permohonan dikembalikan ke Satker', 'danger');
INSERT INTO `pengadaan_statuses` VALUES (4, 'Pengajuan Diterima', 'focus');
INSERT INTO `pengadaan_statuses` VALUES (5, 'Permohonan dikembalikan ke Tingkat Banding', 'danger');
INSERT INTO `pengadaan_statuses` VALUES (6, 'Permohonan Diproses', 'accent');
INSERT INTO `pengadaan_statuses` VALUES (7, 'Permohonan Selesai', 'success');
INSERT INTO `pengadaan_statuses` VALUES (8, 'Ubah Permohonan', 'secondary');

-- ----------------------------
-- Table structure for pengadaan_types
-- ----------------------------
DROP TABLE IF EXISTS `pengadaan_types`;
CREATE TABLE `pengadaan_types`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `state` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pengadaan_types
-- ----------------------------
INSERT INTO `pengadaan_types` VALUES (1, 'Pengadaan Tanah', 'info');
INSERT INTO `pengadaan_types` VALUES (2, 'Pembangunan Baru', 'warning');
INSERT INTO `pengadaan_types` VALUES (3, 'Renovasi/Rehabilitasi/Restorasi', 'success');

-- ----------------------------
-- Table structure for penghapusan_statuses
-- ----------------------------
DROP TABLE IF EXISTS `penghapusan_statuses`;
CREATE TABLE `penghapusan_statuses`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `state` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of penghapusan_statuses
-- ----------------------------
INSERT INTO `penghapusan_statuses` VALUES (1, 'Permohonan Oleh Satker', 'warning');
INSERT INTO `penghapusan_statuses` VALUES (2, 'Permohonan oleh Tingkat Banding', 'info');
INSERT INTO `penghapusan_statuses` VALUES (3, 'Permohonan dikembalikan ke Satker', 'danger');
INSERT INTO `penghapusan_statuses` VALUES (4, 'Pengajuan Diterima', 'focus');
INSERT INTO `penghapusan_statuses` VALUES (5, 'Permohonan dikembalikan ke Tingkat Banding', 'danger');
INSERT INTO `penghapusan_statuses` VALUES (6, 'Permohonan Diproses', 'accent');
INSERT INTO `penghapusan_statuses` VALUES (7, 'Permohonan Selesai', 'success');
INSERT INTO `penghapusan_statuses` VALUES (8, 'Ubah Permohonan', 'secondary');

-- ----------------------------
-- Table structure for penjualan_statuses
-- ----------------------------
DROP TABLE IF EXISTS `penjualan_statuses`;
CREATE TABLE `penjualan_statuses`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `state` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of penjualan_statuses
-- ----------------------------
INSERT INTO `penjualan_statuses` VALUES (1, 'Permohonan Oleh Satker', 'warning');
INSERT INTO `penjualan_statuses` VALUES (2, 'Permohonan oleh Tingkat Banding', 'info');
INSERT INTO `penjualan_statuses` VALUES (3, 'Permohonan dikembalikan ke Satker', 'danger');
INSERT INTO `penjualan_statuses` VALUES (4, 'Pengajuan Diterima', 'focus');
INSERT INTO `penjualan_statuses` VALUES (5, 'Permohonan dikembalikan ke Tingkat Banding', 'danger');
INSERT INTO `penjualan_statuses` VALUES (6, 'Permohonan Diproses', 'accent');
INSERT INTO `penjualan_statuses` VALUES (7, 'Permohonan Selesai', 'success');
INSERT INTO `penjualan_statuses` VALUES (8, 'Ubah Permohonan', 'secondary');

-- ----------------------------
-- Table structure for sewa_statuses
-- ----------------------------
DROP TABLE IF EXISTS `sewa_statuses`;
CREATE TABLE `sewa_statuses`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `state` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sewa_statuses
-- ----------------------------
INSERT INTO `sewa_statuses` VALUES (1, 'Permohonan Oleh Satker', 'warning');
INSERT INTO `sewa_statuses` VALUES (2, 'Permohonan oleh Tingkat Banding', 'info');
INSERT INTO `sewa_statuses` VALUES (3, 'Permohonan dikembalikan ke Satker', 'danger');
INSERT INTO `sewa_statuses` VALUES (4, 'Pengajuan Diterima', 'focus');
INSERT INTO `sewa_statuses` VALUES (5, 'Permohonan dikembalikan ke Tingkat Banding', 'danger');
INSERT INTO `sewa_statuses` VALUES (6, 'Permohonan Diproses', 'accent');
INSERT INTO `sewa_statuses` VALUES (7, 'Permohonan Selesai', 'success');
INSERT INTO `sewa_statuses` VALUES (8, 'Ubah Permohonan', 'secondary');
INSERT INTO `sewa_statuses` VALUES (9, 'Menunggu Tindak Lanjut', 'info');

-- ----------------------------
-- Table structure for category_assets
-- ----------------------------
DROP TABLE IF EXISTS `category_assets`;
CREATE TABLE `category_assets`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `table_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `icon` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `route` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `url` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `order` int(10) NULL DEFAULT NULL,
  `active` tinyint(3) NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 24 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of category_assets
-- ----------------------------
INSERT INTO `category_assets` VALUES (1, 'Persediaan', 'asset_persediaans', 'flaticon-tabs', 'admin.asset.persediaan.index', 'asset/persediaan', 1, 0);
INSERT INTO `category_assets` VALUES (2, 'Persediaan - Untuk Masyarakat', 'asset_persediaan_masyarakats', 'flaticon-layers', 'admin.asset.psmasyarakat.index', 'asset/psmasyarakat', 2, 0);
INSERT INTO `category_assets` VALUES (3, 'Tanah', 'asset_tanahs', 'flaticon-attachment', 'admin.asset.tanah.index', 'asset/tanah', 3, 1);
INSERT INTO `category_assets` VALUES (4, 'Alat Angkutan Bermotor', 'asset_alat_bermotors', 'flaticon-truck', 'admin.asset.alatangkutanbermotor.index', 'asset/alatangkutanbermotor', 4, 1);
INSERT INTO `category_assets` VALUES (5, 'Peralatan & Mesin NON TIK', 'asset_peralatan_non_tiks', 'flaticon-computer', 'admin.asset.peralatannontik.index', 'asset/peralatannontik', 5, 1);
INSERT INTO `category_assets` VALUES (6, 'Peralatan & Mesin Khusus TIK', 'asset_peralatan_khusus_tiks', 'flaticon-comment', 'admin.asset.peralatankhusustik.index', 'asset/peralatankhusustik', 6, 1);
INSERT INTO `category_assets` VALUES (7, 'Alat Berat', 'asset_alat_berats', 'flaticon-edit', 'admin.asset.alatberat.index', 'asset/alatberat', 7, 1);
INSERT INTO `category_assets` VALUES (8, 'Alat Senjata', NULL, 'flaticon-transport', NULL, NULL, 8, 0);
INSERT INTO `category_assets` VALUES (9, 'Bangunan Gedung', 'asset_bangunan_gedungs', 'flaticon-internet', 'admin.asset.bangunangedung.index', 'asset/bangunangedung', 9, 1);
INSERT INTO `category_assets` VALUES (10, 'Rumah Negara', 'asset_rumah_negaras', 'flaticon-imac', 'admin.asset.rumahnegara.index', 'asset/rumahnegara', 10, 1);
INSERT INTO `category_assets` VALUES (11, 'Jalan & Jembatan', 'asset_jalan_jembatans', 'flaticon-web', 'admin.asset.jalanjembatan.index', 'asset/jalanjembatan', 11, 1);
INSERT INTO `category_assets` VALUES (12, 'Bangunan Air & Irigrasi', 'asset_air_irigasis', 'flaticon-share', 'admin.asset.airirigasi.index', 'asset/airirigasi', 12, 1);
INSERT INTO `category_assets` VALUES (13, 'Instalasi & Jaringan', 'asset_instalasi_jaringans', 'flaticon-interface', 'admin.asset.instalasijaringan.index', 'asset/instalasijaringan', 13, 1);
INSERT INTO `category_assets` VALUES (14, 'Aset Tetap Lainnya', 'asset_tetap_lainnyas', 'flaticon-music', 'admin.asset.tetaplainnya.index', 'asset/tetaplainnya', 14, 1);
INSERT INTO `category_assets` VALUES (15, 'Aset Tak Berwujud', 'asset_tak_berwujuds', 'flaticon-route', 'admin.asset.takberwujud.index', 'asset/takberwujud', 15, 1);
INSERT INTO `category_assets` VALUES (16, 'Aset Renovasi', 'asset_renovasis', 'flaticon-lock-1', 'admin.asset.renovasi.index', 'asset/renovasi', 16, 1);
INSERT INTO `category_assets` VALUES (17, 'Konstruksi Dalam Pengerjaan', 'asset_konstruksi_dalam_pengerjaans', 'flaticon-profile', 'admin.asset.konstruksidalampengerjaan.index', 'asset/konstruksidalampengerjaan', 17, 1);
INSERT INTO `category_assets` VALUES (18, 'Barang Bersejarah', NULL, 'flaticon-alert', NULL, NULL, 18, 0);
INSERT INTO `category_assets` VALUES (19, 'BPYBDS', NULL, 'flaticon-line-graph', NULL, NULL, 19, 0);
INSERT INTO `category_assets` VALUES (20, 'Barang Hilang', NULL, 'flaticon-network', NULL, NULL, 20, 0);
INSERT INTO `category_assets` VALUES (21, 'Barang RB Ke Pengelola', NULL, 'flaticon-signs', NULL, NULL, 21, 0);
INSERT INTO `category_assets` VALUES (22, 'Barang Pihak Ketiga', NULL, 'flaticon-symbol', NULL, NULL, 22, 0);
INSERT INTO `category_assets` VALUES (23, 'Hibah DK/TP', NULL, 'flaticon-search', NULL, NULL, 23, 0);

-- ----------------------------
-- Table structure for menus
-- ----------------------------
DROP TABLE IF EXISTS `menus`;
CREATE TABLE `menus`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_parent` int(10) NULL DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `icon` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `route` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `order` int(11) NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `weight` int(11) NOT NULL,
  `active` tinyint(3) NULL DEFAULT 1,
  `type` enum('internal','external') CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT 'internal',
  `position` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT 'top',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 52 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of menus
-- ----------------------------
INSERT INTO `menus` VALUES (1, NULL, 'Usulan', 'add', 'Usulan', NULL, 1, 'usulan', 0, 0, 'internal', 'top');
INSERT INTO `menus` VALUES (2, 1, 'PSP', 'business', 'PSP', 'admin.usulan.psp.index', 1, 'usulan-psp', 1, 0, 'internal', 'top');
INSERT INTO `menus` VALUES (6, 1, 'Penghapusan', 'file', 'Penghapusan', 'admin.usulan.penghapusan.index', 3, 'usulan-penghapusan', 1, 0, 'internal', 'top');
INSERT INTO `menus` VALUES (7, 1, 'Izin Membongkar', 'diagram', 'Izin Membongkar', 'admin.usulan.izinmembongkar.index', 4, 'usulan-izin-membongkar', 1, 0, 'internal', 'top');
INSERT INTO `menus` VALUES (8, 1, 'Alih Fungsi', 'chat-1', 'Alih Fungsi', 'admin.usulan.alihfungsi.index', 5, 'usulan-alih-fungsi', 1, 0, 'internal', 'top');
INSERT INTO `menus` VALUES (9, 1, 'Penjualan Bongkaran', 'users', 'Penjualan Bongkaran', 'admin.usulan.penjualanbongkaran.index', 6, 'usulan-penjualan-bongkaran', 1, 0, 'internal', 'top');
INSERT INTO `menus` VALUES (10, NULL, 'Setting', 'add', 'Master', NULL, 80, 'master', 0, 1, 'internal', 'left');
INSERT INTO `menus` VALUES (11, 10, 'Role', 'business', 'Role', 'admin.master.role.index', 2, 'master-role', 1, 1, 'internal', 'left');
INSERT INTO `menus` VALUES (12, 10, 'Pengguna', 'users', 'Pengguna', 'admin.master.user.index', 3, 'master-pengguna', 1, 1, 'internal', 'left');
INSERT INTO `menus` VALUES (13, 10, 'Dok Template', 'background', 'Dok Template', 'admin.master.doc.index', 4, 'master-doc', 1, 1, 'internal', 'left');
INSERT INTO `menus` VALUES (14, 1, 'Penjualan', 'imac', 'Penjualan', 'admin.usulan.penjualan.index', 2, 'usulan-penjualan', 1, 1, 'internal', 'top');
INSERT INTO `menus` VALUES (15, 1, 'Hibah Masuk', 'mark', 'Hibah Masuk', 'admin.usulan.hibahmasuk.index', 7, 'usulan-hibah-masuk', 1, 0, 'internal', 'top');
INSERT INTO `menus` VALUES (16, 1, 'Pemusnahan', 'internet', 'Pemusnahan', 'admin.usulan.pemusnahan.index', 8, 'usulan-pemusnahan', 1, 0, 'internal', 'top');
INSERT INTO `menus` VALUES (17, 1, 'Sewa', 'circle', 'Sewa', 'admin.usulan.sewa.index', 9, 'usulan-sewa', 1, 0, 'internal', 'top');
INSERT INTO `menus` VALUES (18, 1, 'Tukar Menukar', 'confetti', 'Tukar Menukar', 'admin.usulan.tukarmenukar.index', 10, 'usulan-tukar-menukar', 1, 0, 'internal', 'top');
INSERT INTO `menus` VALUES (19, 1, 'Hibah keluar', 'technology-1', 'Hibah keluar', 'admin.usulan.hibahkeluar.index', 11, 'usulan-hibah-menukar', 1, 0, 'internal', 'top');
INSERT INTO `menus` VALUES (20, 1, 'Pengadaan Barang', 'bag', 'Pengadaan Barang', 'admin.usulan.pengadaanbarang.index', 12, 'usulan-pb', 1, 0, 'internal', 'top');
INSERT INTO `menus` VALUES (21, NULL, 'Dashboard', 'line-graph', 'Dashboard', 'admin.dashboard.index', 1, 'dashboard', 0, 1, 'internal', 'top');
INSERT INTO `menus` VALUES (22, NULL, 'Monitoring', 'browser', 'Monitoring', NULL, 2, 'monitoring', 0, 1, 'internal', 'top');
INSERT INTO `menus` VALUES (23, 22, 'Kelengkapan', 'light', 'Kelengkapan', 'admin.monitoring.kelengkapan.index', 1, 'monitoring-kelengkaapan', 1, 1, 'internal', 'top');
INSERT INTO `menus` VALUES (24, 22, 'Laporan', 'time-1', 'Laporan', 'admin.monitoring.report.index', 2, 'monitoring-report', 1, 0, 'internal', 'top');
INSERT INTO `menus` VALUES (25, 10, 'Import', 'up-arrow', 'Import', 'admin.master.import.index', 1, 'master-import', 1, 0, 'internal', 'left');
INSERT INTO `menus` VALUES (27, 10, 'Satker', 'map', 'Satker', 'admin.master.satker.index', 1, 'master-satker', 1, 1, 'internal', 'left');
INSERT INTO `menus` VALUES (29, NULL, 'Laporan', 'file', 'Laporan', 'admin.underconstruction', 3, 'laporan', 0, 0, 'internal', 'top');
INSERT INTO `menus` VALUES (30, NULL, 'Bantuan', 'info', 'Bantuan', NULL, 90, 'help', 0, 1, 'internal', 'left');
INSERT INTO `menus` VALUES (31, 30, 'Tentang Aplikasi', 'information', 'Tentang Aplikasi', 'https://siper.mahkamahagung.go.id/TENTANG APLIKASI.pdf', 1, 'help-about', 1, 1, 'external', 'left');
INSERT INTO `menus` VALUES (32, 30, 'Regulasi', 'notes', 'Regulasi', 'admin.help.regulation.index', 2, 'help-regulation', 1, 1, 'internal', 'left');
INSERT INTO `menus` VALUES (33, 30, 'Tutorial', 'exclamation', 'Tutorial', 'admin.help.tutorial.index', 3, 'help-tutorial', 1, 1, 'internal', 'left');
INSERT INTO `menus` VALUES (34, 30, 'FAQ', 'network', 'FAQ', 'admin.help.faq.index', 4, 'help-faq', 1, 1, 'internal', 'left');
INSERT INTO `menus` VALUES (35, 10, 'FAQ', 'network', 'FAQ', 'admin.master.faq.index', 5, 'master-faq', 1, 1, 'internal', 'left');
INSERT INTO `menus` VALUES (36, 10, 'Usulan', 'app', 'Usulan', 'admin.master.usulan.index', 6, 'master-usulan', 1, 0, 'internal', 'left');
INSERT INTO `menus` VALUES (37, 22, 'Backup SIMAK', 'download', 'Kirim Backup SIMAK', 'admin.monitoring.simak.index', 3, 'monitoring-simak', 1, 1, 'internal', 'top');
INSERT INTO `menus` VALUES (38, 10, 'Tentang Aplikasi', 'file', 'Tentang Aplikasi', 'admin.master.about.index', 6, 'master-about', 1, 1, 'internal', 'left');
INSERT INTO `menus` VALUES (39, 22, 'Interconnection', 'apps', 'Interconnection', 'admin.monitoring.interconnection.index', 3, 'monitoring-interconnection', 1, 1, 'internal', 'top');
INSERT INTO `menus` VALUES (40, NULL, 'Pengelolaan BMN', 'interface-9 ', 'Pengelolaan BMN', NULL, 60, 'pengelolaan', 0, 1, 'internal', 'top');
INSERT INTO `menus` VALUES (41, 40, 'Penjualan BMN', 'interface-2', 'Penjualan BMN', 'admin.pengelolaan.penjualan.index', 1, 'pengelolaan-penjualan', 1, 1, 'internal', 'top');
INSERT INTO `menus` VALUES (42, 40, 'Penjualan Bongkaran', 'stopwatch', 'Penjualan Bongkaran', 'admin.pengelolaan.bongkaran.index', 2, 'pengelolaan-bongkaran', 2, 1, 'internal', 'top');
INSERT INTO `menus` VALUES (43, 40, 'Sewa', 'folder', 'Sewa', 'admin.pengelolaan.sewa.index', 3, 'pengelolaan-sewa', 3, 1, 'internal', 'top');
INSERT INTO `menus` VALUES (44, 40, 'Penghapusan', 'folder-1 ', 'Penghapusan', 'admin.pengelolaan.penghapusan.index', 4, 'pengelolaan-penghapusan', 4, 1, 'internal', 'top');
INSERT INTO `menus` VALUES (45, NULL, 'Pengadaan Barang', 'clipboard', 'Pengadaan Barang', NULL, 70, 'pengadaan', 0, 1, 'internal', 'top');
INSERT INTO `menus` VALUES (46, 45, 'RKBMN', 'puzzle', 'RKBMN', 'admin.pengadaan.rkbmn.index', 1, 'pengadaan-rkbmn', 1, 1, 'internal', 'top');
INSERT INTO `menus` VALUES (47, 45, 'Usulan Pengadaan', 'edit', 'Usulan Pengadaan', 'admin.pengadaan.usulan.index', 2, 'pengadaan-usulan', 1, 1, 'internal', 'top');
INSERT INTO `menus` VALUES (48, NULL, 'Lapor BMN', 'folder-1 ', 'Lapor BMN', 'admin.lapor.index', 75, 'lapor', 0, 1, 'internal', 'top');
INSERT INTO `menus` VALUES (49, 22, 'Pensertipikasian Tanah', 'clipboard', 'Pensertipikasian Tanah', 'admin.monitoring.sertipikasi.index', 4, 'monitoring-sertipikasi', 1, 1, 'internal', 'top');
INSERT INTO `menus` VALUES (50, 22, 'PSP', 'graph', 'PSP', 'admin.monitoring.psp.index', 5, 'monitoring-psp', 1, 1, 'internal', 'top');
INSERT INTO `menus` VALUES (51, 22, 'Penghapusan BMN', 'pie-chart', 'Penghapusan BMN', 'admin.monitoring.penghapusan.index', 6, 'monitoring-penghapusan', 1, 1, 'internal', 'top');

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `menu_id` int(11) NOT NULL,
  `permission_group_id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `desc` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `active` smallint(3) NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `permissions_name_unique`(`name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 139 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of permissions
-- ----------------------------
INSERT INTO `permissions` VALUES (1, 11, 7, 'permission-master-role', 'Permission', 'Setting Permission for role', '2017-05-18 16:09:22', '2017-05-18 16:09:22', 0);
INSERT INTO `permissions` VALUES (2, 11, 1, 'view-master-role', 'View Role', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (3, 11, 2, 'create-master-role', 'Create Role', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (4, 11, 3, 'edit-master-role', 'Edit Role', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (5, 11, 4, 'delete-master-role', 'Delete Role', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (6, 12, 1, 'view-master-user', 'View User', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (7, 12, 2, 'create-master-user', 'Create User', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (8, 12, 3, 'edit-master-user', 'Edit User', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (9, 12, 4, 'delete-master-user', 'Delete User', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (10, 2, 1, 'view-usulan-psp', 'View Usulan PSP', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (11, 2, 2, 'create-usulan-psp', 'Creatre Usulan PSP', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (12, 2, 3, 'edit-usulan-psp', 'Edit Usulan PSP', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (13, 2, 4, 'delete-usulan-psp', 'Delete Usulan PSP', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (14, 13, 1, 'view-master-doc', 'View Master Doc', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (15, 13, 2, 'create-master-doc', 'Create Master Doc', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (16, 13, 3, 'edit-master-doc', 'Edit Master Doc', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (17, 2, 7, 'proses-usulan-psp', 'Proses Usulan PSP', 'Proses Usulan PSP', NULL, NULL, 0);
INSERT INTO `permissions` VALUES (18, 14, 1, 'view-usulan-penjualan', 'View Usulan Penjualan', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (19, 14, 2, 'create-usulan-penjualan', 'Create Usulan Penjualan', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (20, 14, 3, 'edit-usulan-penjualan', 'Edit Usulan Penjualan', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (21, 14, 4, 'delete-usulan-penjualan', 'Detele Usulan Penjualan', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (22, 14, 7, 'proses-usulan-penjualan', 'Proses Usulan Penjualan', 'Proses Usulan Penjualan', NULL, NULL, 0);
INSERT INTO `permissions` VALUES (23, 6, 1, 'view-usulan-penghapusan', 'View Usulan Penghapusan', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (24, 6, 2, 'create-usulan-penghapusan', 'Create Usulan Penghapusan', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (25, 6, 3, 'edit-usulan-penghapusan', 'Edit Usulan Penghapusan', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (26, 6, 4, 'delete-usulan-penghapusan', 'Detele Usulan Penghapusan', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (27, 6, 7, 'proses-usulan-penghapusan', 'Proses Usulan Penghapusan', 'Proses Usulan Penghapusan', NULL, NULL, 0);
INSERT INTO `permissions` VALUES (28, 7, 1, 'view-usulan-izin-membongkar', 'View Usulan Izin Membongkar', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (29, 7, 2, 'create-usulan-izin-membongkar', 'Create Usulan Izin Membongkar', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (30, 7, 3, 'edit-usulan-izin-membongkar', 'Edit Usulan Izin Membongkar', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (31, 7, 4, 'delete-usulan-izin-membongkar', 'Detele Usulan Izin Membongkar', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (32, 7, 7, 'proses-usulan-izin-membongkar', 'Proses Usulan Izin Membongkar', 'Proses Usulan Izin Membongkar', NULL, NULL, 0);
INSERT INTO `permissions` VALUES (33, 8, 1, 'view-usulan-alih-fungsi', 'View Usulan Alih Fungsi', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (34, 8, 2, 'create-usulan-alih-fungsi', 'Create Usulan Alih Fungsi', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (35, 8, 3, 'edit-usulan-alih-fungsi', 'Edit Usulan Alih Fungsi', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (36, 8, 4, 'delete-usulan-alih-fungsi', 'Detele Usulan Alih Fungsi', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (37, 8, 7, 'proses-usulan-alih-fungsi', 'Proses Usulan Alih Fungsi', 'Proses Usulan Alih Fungsi', NULL, NULL, 0);
INSERT INTO `permissions` VALUES (38, 9, 1, 'view-usulan-penjualan-bongkaran', 'View Usulan Penjualan Bongkaran', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (39, 9, 2, 'create-usulan-penjualan-bongkaran', 'Create Usulan Penjualan Bongkaran', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (40, 9, 3, 'edit-usulan-penjualan-bongkaran', 'Edit Usulan Penjualan Bongkaran', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (41, 9, 4, 'delete-usulan-penjualan-bongkaran', 'Detele Usulan Penjualan Bongkaran', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (42, 9, 7, 'proses-usulan-penjualan-bongkaran', 'Proses Usulan Penjualan Bongkaran', 'Proses Usulan Penjualan Bongkaran', NULL, NULL, 0);
INSERT INTO `permissions` VALUES (43, 15, 1, 'view-usulan-hibah-masuk', 'View Usulan Hibah Masuk', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (44, 15, 2, 'create-usulan-hibah-masuk', 'Create Usulan Hibah Masuk', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (45, 15, 3, 'edit-usulan-hibah-masuk', 'Edit Usulan Hibah Masuk', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (46, 15, 4, 'delete-usulan-hibah-masuk', 'Detele Usulan Hibah Masuk', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (47, 15, 7, 'proses-usulan-hibah-masuk', 'Proses Usulan Hibah Masuk', 'Proses Usulan Hibah Masuk', NULL, NULL, 0);
INSERT INTO `permissions` VALUES (48, 16, 1, 'view-usulan-pemusnahan', 'View Usulan Pemusnahan', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (49, 16, 2, 'create-usulan-pemusnahan', 'Create Usulan Pemusnahan', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (50, 16, 3, 'edit-usulan-pemusnahan', 'Edit Usulan Pemusnahan', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (51, 16, 4, 'delete-usulan-pemusnahan', 'Detele Usulan Pemusnahan', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (52, 16, 7, 'proses-usulan-pemusnahan', 'Proses Usulan Pemusnahan', 'Proses Usulan Pemusnahan', NULL, NULL, 0);
INSERT INTO `permissions` VALUES (53, 17, 1, 'view-usulan-sewa', 'View Usulan Sewa', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (54, 17, 2, 'create-usulan-sewa', 'Create Usulan Sewa', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (55, 17, 3, 'edit-usulan-sewa', 'Edit Usulan Sewa', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (56, 17, 4, 'delete-usulan-sewa', 'Detele Usulan Sewa', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (57, 17, 7, 'proses-usulan-sewa', 'Proses Usulan Sewa', 'Proses Usulan Sewa', NULL, NULL, 0);
INSERT INTO `permissions` VALUES (58, 18, 1, 'view-usulan-tukar-menukar', 'View Tukar Menukar', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (59, 18, 2, 'create-usulan-tukar-menukar', 'Create Tukar Menukar', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (60, 18, 3, 'edit-usulan-tukar-menukar', 'Edit Tukar Menukar', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (61, 18, 4, 'delete-usulan-tukar-menukar', 'Detele Tukar Menukar', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (62, 18, 7, 'proses-usulan-tukar-menukar', 'Proses Tukar Menukar', 'Proses Tukar Menukar', NULL, NULL, 0);
INSERT INTO `permissions` VALUES (63, 19, 1, 'view-usulan-hibah-keluar', 'View Hibah Keluar', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (64, 19, 2, 'create-usulan-hibah-keluar', 'Create Hibah Keluar', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (65, 19, 3, 'edit-usulan-hibah-keluar', 'Edit Hibah Keluar', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (66, 19, 4, 'delete-usulan-hibah-keluar', 'Detele Hibah Keluar', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (67, 19, 7, 'proses-usulan-hibah-keluar', 'Proses Hibah Keluar', 'Proses Hibah Keluar', NULL, NULL, 0);
INSERT INTO `permissions` VALUES (68, 20, 1, 'view-usulan-pengadaan-barang', 'View Pengadaan Barang', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (69, 20, 2, 'create-usulan-pengadaan-barang', 'Create Pengadaan Barang', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (70, 20, 3, 'edit-usulan-pengadaan-barang', 'Edit Pengadaan Barang', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (71, 20, 4, 'delete-usulan-pengadaan-barang', 'Detele Pengadaan Barang', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (72, 20, 7, 'proses-usulan-pengadaan-barang', 'Proses Pengadaan Barang', 'Proses Pengadaan Barang', NULL, NULL, 0);
INSERT INTO `permissions` VALUES (73, 21, 1, 'view-dashboard', 'View Dashboard', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (74, 27, 1, 'view-master-satker', 'View Profile Satker', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (75, 27, 3, 'edit-master-satker', 'Edit Profile Satker', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (76, 23, 1, 'view-monitoring-kelengkapan', 'View Monitoring Kelengkapan', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (77, 25, 1, 'view-master-import', 'View Master Import', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (78, 25, 2, 'create-master-import', 'Create Master Import', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (81, 35, 1, 'view-master-faq', 'View Master FAQ', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (82, 35, 2, 'create-master-faq', 'Create Master FAQ', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (83, 35, 3, 'edit-master-faq', 'Edit Master FAQ', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (84, 35, 4, 'delete-master-faq', 'Delete Master FAQ', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (85, 36, 1, 'view-master-usulan', 'View Master Usulan', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (86, 36, 2, 'create-master-usulan', 'Create Master Usulan', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (87, 31, 1, 'view-help-about', 'View Help About', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (88, 32, 1, 'view-help-regulation', 'View Help Regulation', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (89, 32, 2, 'create-help-regulation', 'Create Help Regulation', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (90, 32, 4, 'delete-help-regulation', 'Delete Help Regulation', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (91, 33, 1, 'view-help-tutorial', 'View Help Tutorial', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (92, 33, 2, 'create-help-tutorial', 'Create Help Tutorial', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (93, 33, 4, 'delete-help-tutorial', 'Delete Help Tutorial', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (94, 34, 1, 'view-help-faq', 'View Help FAQ', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (95, 11, 7, 'view-all-asset', 'View All Asset', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (96, 11, 7, 'view-all-wilayah-asset', 'View All Wilayah Asset', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (97, 11, 7, 'view-all-satker-asset', 'View All Satker Asset', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (98, 11, 7, 'view-all-lingkungan-asset', 'View All Lingkungan Asset', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (99, 37, 1, 'view-monitoring-simak', 'View Simak', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (100, 37, 2, 'create-monitoring-simak', 'Create Simak', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (101, 12, 7, 'create-limited-user', 'Create Limited User', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (102, 38, 1, 'view-master-about', 'View Master About', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (103, 38, 3, 'edit-master-about', 'Edit Master About', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (104, 12, 7, 'import-asset', 'Import Asset', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (105, 41, 1, 'view-pengelolaan-penjualan', 'View Pengelolaan Penjualan', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (106, 41, 2, 'create-pengelolaan-penjualan', 'Create Pengelolaan Penjualan', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (107, 41, 3, 'edit-pengelolaan-penjualan', 'Edit Pengelolaan Penjualan', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (108, 43, 1, 'view-pengelolaan-sewa', 'View Pengelolaan Sewa', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (109, 43, 2, 'create-pengelolaan-sewa', 'Create Pengelolaan Sewa', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (110, 43, 3, 'edit-pengelolaan-sewa', 'Edit Pengelolaan Sewa', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (111, 42, 1, 'view-pengelolaan-bongkaran', 'View Pengelolaan Bongkaran', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (112, 42, 2, 'create-pengelolaan-bongkaran', 'Create Pengelolaan Bongkaran', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (113, 42, 3, 'edit-pengelolaan-bongkaran', 'Edit Pengelolaan Bongkaran', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (114, 44, 1, 'view-pengelolaan-penghapusan', 'View Pengelolaan Penghapusan', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (115, 44, 2, 'create-pengelolaan-penghapusan', 'Create Pengelolaan Penghapusan', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (116, 44, 3, 'edit-pengelolaan-penghapusan', 'Edit Pengelolaan Penghapusan', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (117, 47, 1, 'view-pengadaan-usulan', 'View Pengadaan Usulan', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (118, 47, 2, 'create-pengadaan-usulan', 'Create Pengadaan Usulan', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (119, 47, 3, 'edit-pengadaan-usulan', 'Edit Pengadaan Usulan', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (120, 48, 1, 'view-lapor', 'View Lapor BMN', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (121, 48, 2, 'create-lapor', 'Create Lapor BMN', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (122, 48, 4, 'delete-lapor', 'Delete Lapor BMN', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (123, 48, 7, 'balas-lapor', 'Balas Lapor BMN', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (124, 50, 1, 'view-monitoring-psp', 'View Monitoring PSP', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (125, 49, 1, 'view-monitoring-sertipikasi', 'View Monitoring Sertipikasi', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (126, 49, 2, 'create-monitoring-sertipikasi', 'Create Monitoring Sertipikasi', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (127, 49, 4, 'delete-monitoring-sertipikasi', 'Delete Monitoring Sertipikasi', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (128, 49, 3, 'edit-monitoring-sertipikasi', 'Edit Monitoring Sertipikasi', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (129, 46, 1, 'view-pengadaan-rkbmn', 'View Pengadaan RKBMN', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (130, 46, 2, 'create-pengadaan-rkbmn', 'Create Pengadaan RKBMN', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (131, 46, 4, 'delete-pengadaan-rkbmn', 'Delete Pengadaan RKBMN', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (132, 46, 7, 'pagu-pengadaan-rkbmn', 'Pagu Pengadaan RKBMN', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (133, 51, 1, 'view-monitoring-penghapusan', 'View Monitoring Penghapusan', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (134, 51, 2, 'create-monitoring-penghapusan', 'Create Monitoring Penghapusan', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (135, 51, 4, 'delete-monitoring-penghapusan', 'Delete Monitoring Penghapusan', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (136, 39, 1, 'view-monitoring-interconnection', 'View Monitoring Interconnection', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (137, 27, 7, 'tingkatbanding-master-satker', 'Tingkat Banding Master Asset', NULL, NULL, NULL, 1);
INSERT INTO `permissions` VALUES (138, 48, 7, 'selesai-lapor', 'Selesai Lapor BMN', NULL, NULL, NULL, 1);

-- ----------------------------
-- Table structure for role_permissions
-- ----------------------------
DROP TABLE IF EXISTS `role_permissions`;
CREATE TABLE `role_permissions`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 572 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of role_permissions
-- ----------------------------
INSERT INTO `role_permissions` VALUES (277, 2, 73);
INSERT INTO `role_permissions` VALUES (278, 2, 74);
INSERT INTO `role_permissions` VALUES (279, 2, 75);
INSERT INTO `role_permissions` VALUES (280, 2, 76);
INSERT INTO `role_permissions` VALUES (283, 2, 81);
INSERT INTO `role_permissions` VALUES (284, 2, 82);
INSERT INTO `role_permissions` VALUES (285, 2, 83);
INSERT INTO `role_permissions` VALUES (286, 2, 84);
INSERT INTO `role_permissions` VALUES (289, 2, 87);
INSERT INTO `role_permissions` VALUES (290, 2, 88);
INSERT INTO `role_permissions` VALUES (291, 2, 89);
INSERT INTO `role_permissions` VALUES (292, 2, 90);
INSERT INTO `role_permissions` VALUES (293, 2, 91);
INSERT INTO `role_permissions` VALUES (294, 2, 92);
INSERT INTO `role_permissions` VALUES (295, 2, 93);
INSERT INTO `role_permissions` VALUES (296, 2, 94);
INSERT INTO `role_permissions` VALUES (297, 3, 73);
INSERT INTO `role_permissions` VALUES (298, 3, 76);
INSERT INTO `role_permissions` VALUES (299, 5, 73);
INSERT INTO `role_permissions` VALUES (300, 5, 76);
INSERT INTO `role_permissions` VALUES (301, 4, 73);
INSERT INTO `role_permissions` VALUES (302, 4, 76);
INSERT INTO `role_permissions` VALUES (303, 6, 73);
INSERT INTO `role_permissions` VALUES (304, 6, 76);
INSERT INTO `role_permissions` VALUES (305, 3, 87);
INSERT INTO `role_permissions` VALUES (306, 3, 88);
INSERT INTO `role_permissions` VALUES (307, 3, 91);
INSERT INTO `role_permissions` VALUES (308, 3, 94);
INSERT INTO `role_permissions` VALUES (309, 5, 87);
INSERT INTO `role_permissions` VALUES (310, 5, 88);
INSERT INTO `role_permissions` VALUES (311, 5, 91);
INSERT INTO `role_permissions` VALUES (312, 5, 94);
INSERT INTO `role_permissions` VALUES (313, 4, 87);
INSERT INTO `role_permissions` VALUES (314, 4, 88);
INSERT INTO `role_permissions` VALUES (315, 4, 91);
INSERT INTO `role_permissions` VALUES (316, 4, 94);
INSERT INTO `role_permissions` VALUES (317, 6, 87);
INSERT INTO `role_permissions` VALUES (318, 6, 88);
INSERT INTO `role_permissions` VALUES (319, 6, 91);
INSERT INTO `role_permissions` VALUES (320, 6, 94);
INSERT INTO `role_permissions` VALUES (321, 7, 73);
INSERT INTO `role_permissions` VALUES (322, 7, 76);
INSERT INTO `role_permissions` VALUES (323, 7, 87);
INSERT INTO `role_permissions` VALUES (324, 7, 88);
INSERT INTO `role_permissions` VALUES (325, 7, 91);
INSERT INTO `role_permissions` VALUES (326, 7, 94);
INSERT INTO `role_permissions` VALUES (327, 2, 95);
INSERT INTO `role_permissions` VALUES (328, 7, 96);
INSERT INTO `role_permissions` VALUES (329, 3, 97);
INSERT INTO `role_permissions` VALUES (331, 4, 97);
INSERT INTO `role_permissions` VALUES (334, 8, 73);
INSERT INTO `role_permissions` VALUES (335, 8, 76);
INSERT INTO `role_permissions` VALUES (336, 8, 87);
INSERT INTO `role_permissions` VALUES (337, 8, 88);
INSERT INTO `role_permissions` VALUES (338, 8, 91);
INSERT INTO `role_permissions` VALUES (339, 8, 94);
INSERT INTO `role_permissions` VALUES (340, 8, 98);
INSERT INTO `role_permissions` VALUES (341, 2, 99);
INSERT INTO `role_permissions` VALUES (344, 6, 99);
INSERT INTO `role_permissions` VALUES (345, 7, 99);
INSERT INTO `role_permissions` VALUES (346, 3, 99);
INSERT INTO `role_permissions` VALUES (347, 4, 99);
INSERT INTO `role_permissions` VALUES (348, 5, 99);
INSERT INTO `role_permissions` VALUES (351, 5, 96);
INSERT INTO `role_permissions` VALUES (352, 5, 98);
INSERT INTO `role_permissions` VALUES (353, 6, 96);
INSERT INTO `role_permissions` VALUES (354, 6, 98);
INSERT INTO `role_permissions` VALUES (355, 5, 101);
INSERT INTO `role_permissions` VALUES (356, 3, 101);
INSERT INTO `role_permissions` VALUES (357, 3, 6);
INSERT INTO `role_permissions` VALUES (358, 3, 7);
INSERT INTO `role_permissions` VALUES (359, 3, 8);
INSERT INTO `role_permissions` VALUES (360, 3, 9);
INSERT INTO `role_permissions` VALUES (361, 5, 6);
INSERT INTO `role_permissions` VALUES (362, 5, 7);
INSERT INTO `role_permissions` VALUES (363, 5, 8);
INSERT INTO `role_permissions` VALUES (364, 5, 9);
INSERT INTO `role_permissions` VALUES (365, 9, 6);
INSERT INTO `role_permissions` VALUES (366, 9, 7);
INSERT INTO `role_permissions` VALUES (367, 9, 8);
INSERT INTO `role_permissions` VALUES (368, 9, 9);
INSERT INTO `role_permissions` VALUES (369, 9, 73);
INSERT INTO `role_permissions` VALUES (370, 9, 76);
INSERT INTO `role_permissions` VALUES (371, 9, 87);
INSERT INTO `role_permissions` VALUES (372, 9, 88);
INSERT INTO `role_permissions` VALUES (373, 9, 91);
INSERT INTO `role_permissions` VALUES (374, 9, 94);
INSERT INTO `role_permissions` VALUES (375, 9, 96);
INSERT INTO `role_permissions` VALUES (376, 9, 99);
INSERT INTO `role_permissions` VALUES (377, 9, 101);
INSERT INTO `role_permissions` VALUES (378, 10, 6);
INSERT INTO `role_permissions` VALUES (379, 10, 7);
INSERT INTO `role_permissions` VALUES (380, 10, 8);
INSERT INTO `role_permissions` VALUES (381, 10, 9);
INSERT INTO `role_permissions` VALUES (382, 10, 73);
INSERT INTO `role_permissions` VALUES (383, 10, 76);
INSERT INTO `role_permissions` VALUES (384, 10, 87);
INSERT INTO `role_permissions` VALUES (385, 10, 88);
INSERT INTO `role_permissions` VALUES (386, 10, 91);
INSERT INTO `role_permissions` VALUES (387, 10, 94);
INSERT INTO `role_permissions` VALUES (388, 10, 98);
INSERT INTO `role_permissions` VALUES (389, 10, 101);
INSERT INTO `role_permissions` VALUES (390, 11, 6);
INSERT INTO `role_permissions` VALUES (391, 11, 7);
INSERT INTO `role_permissions` VALUES (392, 11, 8);
INSERT INTO `role_permissions` VALUES (393, 11, 9);
INSERT INTO `role_permissions` VALUES (394, 11, 73);
INSERT INTO `role_permissions` VALUES (395, 11, 74);
INSERT INTO `role_permissions` VALUES (396, 11, 75);
INSERT INTO `role_permissions` VALUES (397, 11, 76);
INSERT INTO `role_permissions` VALUES (400, 11, 81);
INSERT INTO `role_permissions` VALUES (401, 11, 82);
INSERT INTO `role_permissions` VALUES (402, 11, 83);
INSERT INTO `role_permissions` VALUES (403, 11, 84);
INSERT INTO `role_permissions` VALUES (406, 11, 87);
INSERT INTO `role_permissions` VALUES (407, 11, 88);
INSERT INTO `role_permissions` VALUES (408, 11, 89);
INSERT INTO `role_permissions` VALUES (409, 11, 90);
INSERT INTO `role_permissions` VALUES (410, 11, 91);
INSERT INTO `role_permissions` VALUES (411, 11, 92);
INSERT INTO `role_permissions` VALUES (412, 11, 93);
INSERT INTO `role_permissions` VALUES (413, 11, 94);
INSERT INTO `role_permissions` VALUES (414, 11, 95);
INSERT INTO `role_permissions` VALUES (415, 11, 99);
INSERT INTO `role_permissions` VALUES (418, 11, 102);
INSERT INTO `role_permissions` VALUES (419, 11, 103);
INSERT INTO `role_permissions` VALUES (420, 11, 104);
INSERT INTO `role_permissions` VALUES (421, 3, 100);
INSERT INTO `role_permissions` VALUES (422, 4, 105);
INSERT INTO `role_permissions` VALUES (423, 4, 106);
INSERT INTO `role_permissions` VALUES (424, 4, 107);
INSERT INTO `role_permissions` VALUES (425, 3, 105);
INSERT INTO `role_permissions` VALUES (426, 3, 106);
INSERT INTO `role_permissions` VALUES (427, 3, 107);
INSERT INTO `role_permissions` VALUES (428, 5, 105);
INSERT INTO `role_permissions` VALUES (429, 6, 105);
INSERT INTO `role_permissions` VALUES (430, 11, 105);
INSERT INTO `role_permissions` VALUES (431, 2, 105);
INSERT INTO `role_permissions` VALUES (432, 4, 108);
INSERT INTO `role_permissions` VALUES (433, 4, 109);
INSERT INTO `role_permissions` VALUES (434, 4, 110);
INSERT INTO `role_permissions` VALUES (435, 3, 108);
INSERT INTO `role_permissions` VALUES (436, 3, 109);
INSERT INTO `role_permissions` VALUES (437, 3, 110);
INSERT INTO `role_permissions` VALUES (438, 5, 108);
INSERT INTO `role_permissions` VALUES (439, 6, 108);
INSERT INTO `role_permissions` VALUES (440, 11, 108);
INSERT INTO `role_permissions` VALUES (441, 2, 108);
INSERT INTO `role_permissions` VALUES (442, 3, 111);
INSERT INTO `role_permissions` VALUES (443, 3, 112);
INSERT INTO `role_permissions` VALUES (444, 3, 113);
INSERT INTO `role_permissions` VALUES (445, 4, 111);
INSERT INTO `role_permissions` VALUES (446, 4, 112);
INSERT INTO `role_permissions` VALUES (447, 4, 113);
INSERT INTO `role_permissions` VALUES (448, 5, 111);
INSERT INTO `role_permissions` VALUES (449, 6, 111);
INSERT INTO `role_permissions` VALUES (450, 11, 111);
INSERT INTO `role_permissions` VALUES (451, 2, 111);
INSERT INTO `role_permissions` VALUES (452, 3, 114);
INSERT INTO `role_permissions` VALUES (453, 3, 115);
INSERT INTO `role_permissions` VALUES (454, 3, 116);
INSERT INTO `role_permissions` VALUES (455, 4, 114);
INSERT INTO `role_permissions` VALUES (456, 4, 115);
INSERT INTO `role_permissions` VALUES (457, 4, 116);
INSERT INTO `role_permissions` VALUES (458, 5, 114);
INSERT INTO `role_permissions` VALUES (459, 6, 114);
INSERT INTO `role_permissions` VALUES (460, 11, 114);
INSERT INTO `role_permissions` VALUES (461, 2, 114);
INSERT INTO `role_permissions` VALUES (462, 3, 120);
INSERT INTO `role_permissions` VALUES (463, 3, 121);
INSERT INTO `role_permissions` VALUES (464, 3, 122);
INSERT INTO `role_permissions` VALUES (465, 4, 120);
INSERT INTO `role_permissions` VALUES (466, 4, 121);
INSERT INTO `role_permissions` VALUES (467, 4, 122);
INSERT INTO `role_permissions` VALUES (468, 2, 120);
INSERT INTO `role_permissions` VALUES (469, 2, 123);
INSERT INTO `role_permissions` VALUES (470, 11, 120);
INSERT INTO `role_permissions` VALUES (471, 11, 123);
INSERT INTO `role_permissions` VALUES (472, 11, 124);
INSERT INTO `role_permissions` VALUES (473, 11, 125);
INSERT INTO `role_permissions` VALUES (474, 11, 126);
INSERT INTO `role_permissions` VALUES (475, 11, 127);
INSERT INTO `role_permissions` VALUES (476, 2, 124);
INSERT INTO `role_permissions` VALUES (477, 2, 125);
INSERT INTO `role_permissions` VALUES (478, 2, 126);
INSERT INTO `role_permissions` VALUES (479, 2, 127);
INSERT INTO `role_permissions` VALUES (480, 3, 125);
INSERT INTO `role_permissions` VALUES (481, 3, 128);
INSERT INTO `role_permissions` VALUES (482, 4, 125);
INSERT INTO `role_permissions` VALUES (483, 4, 128);
INSERT INTO `role_permissions` VALUES (484, 11, 117);
INSERT INTO `role_permissions` VALUES (485, 11, 118);
INSERT INTO `role_permissions` VALUES (486, 11, 119);
INSERT INTO `role_permissions` VALUES (487, 11, 129);
INSERT INTO `role_permissions` VALUES (488, 11, 130);
INSERT INTO `role_permissions` VALUES (489, 11, 131);
INSERT INTO `role_permissions` VALUES (490, 3, 117);
INSERT INTO `role_permissions` VALUES (491, 3, 118);
INSERT INTO `role_permissions` VALUES (492, 3, 119);
INSERT INTO `role_permissions` VALUES (493, 4, 117);
INSERT INTO `role_permissions` VALUES (494, 4, 118);
INSERT INTO `role_permissions` VALUES (495, 4, 119);
INSERT INTO `role_permissions` VALUES (496, 9, 117);
INSERT INTO `role_permissions` VALUES (497, 2, 117);
INSERT INTO `role_permissions` VALUES (498, 7, 117);
INSERT INTO `role_permissions` VALUES (499, 2, 129);
INSERT INTO `role_permissions` VALUES (500, 7, 129);
INSERT INTO `role_permissions` VALUES (501, 5, 117);
INSERT INTO `role_permissions` VALUES (502, 5, 129);
INSERT INTO `role_permissions` VALUES (503, 6, 117);
INSERT INTO `role_permissions` VALUES (504, 6, 129);
INSERT INTO `role_permissions` VALUES (505, 3, 129);
INSERT INTO `role_permissions` VALUES (506, 4, 129);
INSERT INTO `role_permissions` VALUES (507, 11, 132);
INSERT INTO `role_permissions` VALUES (511, 2, 133);
INSERT INTO `role_permissions` VALUES (512, 5, 120);
INSERT INTO `role_permissions` VALUES (513, 5, 124);
INSERT INTO `role_permissions` VALUES (514, 5, 125);
INSERT INTO `role_permissions` VALUES (515, 5, 133);
INSERT INTO `role_permissions` VALUES (516, 6, 120);
INSERT INTO `role_permissions` VALUES (517, 6, 124);
INSERT INTO `role_permissions` VALUES (518, 6, 125);
INSERT INTO `role_permissions` VALUES (519, 6, 133);
INSERT INTO `role_permissions` VALUES (520, 3, 124);
INSERT INTO `role_permissions` VALUES (521, 3, 133);
INSERT INTO `role_permissions` VALUES (522, 4, 124);
INSERT INTO `role_permissions` VALUES (523, 4, 133);
INSERT INTO `role_permissions` VALUES (524, 10, 99);
INSERT INTO `role_permissions` VALUES (525, 10, 105);
INSERT INTO `role_permissions` VALUES (526, 10, 108);
INSERT INTO `role_permissions` VALUES (527, 10, 111);
INSERT INTO `role_permissions` VALUES (528, 10, 114);
INSERT INTO `role_permissions` VALUES (529, 10, 117);
INSERT INTO `role_permissions` VALUES (530, 10, 120);
INSERT INTO `role_permissions` VALUES (531, 10, 124);
INSERT INTO `role_permissions` VALUES (532, 10, 125);
INSERT INTO `role_permissions` VALUES (533, 10, 129);
INSERT INTO `role_permissions` VALUES (534, 10, 133);
INSERT INTO `role_permissions` VALUES (535, 7, 105);
INSERT INTO `role_permissions` VALUES (536, 7, 108);
INSERT INTO `role_permissions` VALUES (537, 7, 111);
INSERT INTO `role_permissions` VALUES (538, 7, 114);
INSERT INTO `role_permissions` VALUES (539, 7, 120);
INSERT INTO `role_permissions` VALUES (540, 7, 124);
INSERT INTO `role_permissions` VALUES (541, 7, 125);
INSERT INTO `role_permissions` VALUES (542, 7, 133);
INSERT INTO `role_permissions` VALUES (543, 8, 99);
INSERT INTO `role_permissions` VALUES (544, 8, 105);
INSERT INTO `role_permissions` VALUES (545, 8, 108);
INSERT INTO `role_permissions` VALUES (546, 8, 111);
INSERT INTO `role_permissions` VALUES (547, 8, 114);
INSERT INTO `role_permissions` VALUES (548, 8, 117);
INSERT INTO `role_permissions` VALUES (549, 8, 120);
INSERT INTO `role_permissions` VALUES (550, 8, 124);
INSERT INTO `role_permissions` VALUES (551, 8, 125);
INSERT INTO `role_permissions` VALUES (552, 8, 129);
INSERT INTO `role_permissions` VALUES (553, 8, 133);
INSERT INTO `role_permissions` VALUES (554, 9, 105);
INSERT INTO `role_permissions` VALUES (555, 9, 108);
INSERT INTO `role_permissions` VALUES (556, 9, 111);
INSERT INTO `role_permissions` VALUES (557, 9, 114);
INSERT INTO `role_permissions` VALUES (558, 9, 120);
INSERT INTO `role_permissions` VALUES (559, 9, 124);
INSERT INTO `role_permissions` VALUES (560, 9, 125);
INSERT INTO `role_permissions` VALUES (561, 9, 129);
INSERT INTO `role_permissions` VALUES (562, 9, 133);
INSERT INTO `role_permissions` VALUES (563, 11, 14);
INSERT INTO `role_permissions` VALUES (564, 11, 15);
INSERT INTO `role_permissions` VALUES (565, 11, 16);
INSERT INTO `role_permissions` VALUES (566, 11, 133);
INSERT INTO `role_permissions` VALUES (567, 11, 134);
INSERT INTO `role_permissions` VALUES (568, 11, 135);
INSERT INTO `role_permissions` VALUES (569, 11, 136);
INSERT INTO `role_permissions` VALUES (570, 11, 137);
INSERT INTO `role_permissions` VALUES (571, 11, 138);

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_parent` int(10) NULL DEFAULT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `level` int(11) NOT NULL,
  `type` enum('fungsional','satker') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES (1, NULL, 'Super Admin', 'superadmin', 'One Ring to rule them all', 0, 'fungsional', 1, NULL, '2018-03-06 23:52:22', '2018-03-06 23:52:22');
INSERT INTO `roles` VALUES (2, 3, 'Pusat', 'pusat', NULL, 1, 'fungsional', 1, NULL, '2018-03-06 23:52:22', '2021-05-28 17:09:55');
INSERT INTO `roles` VALUES (3, 1, 'Admin Satker', 'admin-satker', NULL, 10, 'fungsional', 0, NULL, '2018-08-19 13:19:22', '2019-05-28 00:55:40');
INSERT INTO `roles` VALUES (4, 3, 'Satker', 'satker', NULL, 11, 'fungsional', 0, NULL, '2018-08-19 15:49:26', '2021-05-28 17:08:01');
INSERT INTO `roles` VALUES (5, 1, 'Admin Tingkat Banding', 'admin-tingkat-banding', NULL, 10, 'fungsional', 0, NULL, '2018-08-22 00:57:21', '2019-05-28 00:56:20');
INSERT INTO `roles` VALUES (6, 5, 'Tingkat Banding', 'tingkat-banding', NULL, 11, 'fungsional', 0, NULL, '2018-08-22 00:57:42', '2018-08-22 00:57:55');
INSERT INTO `roles` VALUES (7, 9, 'Korwil', 'korwil', 'Kordinator Wilayah', 9, 'fungsional', 0, NULL, '2019-05-13 21:58:35', '2021-05-28 17:11:39');
INSERT INTO `roles` VALUES (8, 10, 'Eselon', 'eselon', 'Eselon', 8, 'fungsional', 0, NULL, '2019-05-14 23:10:26', '2021-05-28 17:11:51');
INSERT INTO `roles` VALUES (9, 1, 'Admin Korwil', 'admin-korwil', NULL, 88, 'fungsional', 0, NULL, '2019-05-28 00:55:05', '2019-05-28 00:55:05');
INSERT INTO `roles` VALUES (10, 11, 'Admin Eselon', 'admin-eselon', NULL, 88, 'fungsional', 0, NULL, '2019-05-28 00:55:15', '2021-05-12 11:54:30');
INSERT INTO `roles` VALUES (11, 1, 'Admin Pusat', 'admin-pusat', NULL, 78, 'fungsional', 0, NULL, '2019-06-12 20:48:15', '2019-06-12 20:48:15');

-- ----------------------------
-- Table structure for satkers
-- ----------------------------
DROP TABLE IF EXISTS `satkers`;
CREATE TABLE `satkers`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_wilayah` int(10) NOT NULL,
  `kode` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `city` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `dirjen` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `kpknl` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `kanwil` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `satker_type` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `tanggal_update` datetime(0) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `kode`(`kode`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1594 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of satkers
-- ----------------------------
INSERT INTO `satkers` VALUES (1, 35, '005010199663157000KP', 'BADAN URUSAN ADMINISTRASI', 'pusat', 'Jakarta', 'Badan Urusan Administrasi', NULL, NULL, 'PUSAT', NULL, '2018-08-08 18:10:18', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (2, 2, '005010200097666000KD', 'PENGADILAN NEGERI CIANJUR', 'general', 'Cianjur', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bogor', 'Kantor Wilayah DJKN Jawa Barat', 'PN', NULL, '2018-08-08 18:10:18', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (3, 2, '005010200400766000KD', 'PENGADILAN AGAMA INDRAMAYU', 'general', 'Indramayu', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Cirebon', 'Kantor Wilayah DJKN Jawa Barat', 'PA', NULL, '2018-08-08 18:10:18', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (4, 3, '005010300097982000KD', 'PENGADILAN NEGERI BOYOLALI', 'general', 'Boyolali', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Surakarta', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PN', NULL, '2018-08-08 18:10:18', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (5, 3, '005010300401024000KD', 'PENGADILAN AGAMA TEMANGGUNG', 'general', 'Temanggung', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Semarang', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2018-08-08 18:10:18', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (6, 3, '005010300401168000KD', 'PENGADILAN AGAMA SUKOHARJO', 'general', 'Sukoharjo', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Surakarta', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2018-08-08 18:10:18', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (7, 4, '005010400400342000KD', 'PENGADILAN TINGGI YOGYAKARTA', 'tingkatbanding', 'Yogyakarta', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Yogyakarta', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PN', NULL, '2018-08-08 18:10:18', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (8, 4, '005010400547657000KD', 'PENGADILAN TINGGI AGAMA D.I YOGYAKARTA', 'tingkatbanding', 'Yogyakarta', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Yogyakarta', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2018-08-08 18:10:18', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (9, 5, '005010500098111000KD', 'PENGADILAN NEGERI SURABAYA', 'general', 'Surabaya', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Surabaya', 'Kantor Wilayah DJKN Jawa Timur', 'PN', NULL, '2018-08-08 18:10:18', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (10, 5, '005010500098192000KD', 'PENGADILAN NEGERI BONDOWOSO', 'general', 'Bondowoso', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jember', 'Kantor Wilayah DJKN Jawa Timur', 'PN', NULL, '2018-08-08 18:10:18', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (11, 5, '005010500098200000KD', 'PENGADILAN NEGERI JEMBER', 'general', 'Jember', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jember', 'Kantor Wilayah DJKN Jawa Timur', 'PN', NULL, '2018-08-08 18:10:18', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (12, 5, '005010500098256000KD', 'PENGADILAN NEGERI TULUNGAGUNG', 'general', 'Tulungagung', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Malang', 'Kantor Wilayah DJKN Jawa Timur', 'PN', NULL, '2018-08-08 18:10:18', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (13, 5, '005010500098331000KD', 'PENGADILAN NEGERI KRAKSAAN', 'general', 'Kraksaan', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jember', 'Kantor Wilayah DJKN Jawa Timur', 'PN', NULL, '2018-08-08 18:10:18', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (14, 5, '005010500401369000KD', 'PENGADILAN AGAMA BANYUWANGI', 'general', 'Banyuwangi', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jember', 'Kantor Wilayah DJKN Jawa Timur', 'PA', NULL, '2018-08-08 18:10:18', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (15, 5, '005010500401381000KD', 'PENGADILAN AGAMA TULUNGAGUNG', 'general', 'Tulungagung', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Malang', 'Kantor Wilayah DJKN Jawa Timur', 'PA', NULL, '2018-08-08 18:10:18', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (16, 5, '005010500401426000KD', 'PENGADILAN AGAMA MALANG', 'general', 'Malang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Malang', 'Kantor Wilayah DJKN Jawa Timur', 'PA', NULL, '2018-08-08 18:10:18', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (17, 5, '005010500626156000KD', 'PENGADILAN NEGERI KEPANJEN KLAS 1. B KABUPATEN MALANG', 'general', 'Kab.Malang, Jawa Timur', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Malang', 'Kantor Wilayah DJKN Jawa Timur', 'PN', NULL, '2018-08-08 18:10:18', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (18, 6, '005010600663182000KD', 'DILMIL. I - 01 BANDA ACEH', 'general', 'Banda Aceh', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banda Aceh', 'Kantor Wilayah DJKN Aceh', 'PM', NULL, '2018-08-08 18:10:18', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (19, 7, '005010700098718000KD', 'PENGADILAN NEGERI TARUTUNG', 'general', 'Tarutung', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Padangsidimpuan', 'Kantor Wilayah DJKN Sumatera Utara', 'PN', NULL, '2018-08-08 18:10:18', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (20, 7, '005010700400389000KD', 'PENGADILAN NEGERI KISARAN', 'general', 'Kisaran', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kisaran', 'Kantor Wilayah DJKN Sumatera Utara', 'PN', NULL, '2018-08-08 18:10:18', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (21, 7, '005010700663199000KD', 'PENGADILAN MILITER I-02 MEDAN', 'general', 'Medan', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', 'Kantor Pelayanan Kekayaan Negara dan Lelang Medan', 'Kantor Wilayah DJKN Sumatera Utara', 'PM', NULL, '2018-08-08 18:10:18', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (22, 8, '005010800400446000KD', 'PENGADILAN NEGERI KOTO BARU', 'general', 'Kotobaru', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Padang', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PN', NULL, '2018-08-08 18:10:18', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (23, 8, '005010800401916000KD', 'PENGADILAN AGAMA PARIAMAN', 'general', 'Pariaman', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Padang', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PA', NULL, '2018-08-08 18:10:18', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (24, 8, '005010800402050000KD', 'PENGADILAN AGAMA PAYAKUMBUH', 'general', 'Payakumbuh', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bukittinggi', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PA', NULL, '2018-08-08 18:10:18', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (25, 9, '005010900477261000KD', 'PENGADILAN NEGERI ROKAN HILIR', 'general', 'Rokan Hilir', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Dumai', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PN', NULL, '2018-08-08 18:10:18', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (26, 10, '005011000098917000KD', 'PENGADILAN NEGERI KUALA TUNGKAL', 'general', 'Kuala Tungkal', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jambi', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PN', NULL, '2018-08-08 18:10:18', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (27, 11, '005011100098963000KD', 'PENGADILAN NEGERI BATURAJA', 'general', 'Baturaja', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Palembang', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PN', NULL, '2018-08-08 18:10:18', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (28, 14, '005011400099134000KD', 'PENGADILAN NEGERI PANGKALAN BUN ', 'general', 'Pangkalan Bun', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pangkalan Bun', 'Kantor Wilayah DJKN Kalimantan Selatan Dan Tengah', 'PN', NULL, '2018-08-08 18:10:18', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (29, 15, '005011500402571000KD', 'PENGADILAN AGAMA NEGARA', 'general', 'Negara', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banjarmasin', 'Kantor Wilayah DJKN Kalimantan Selatan Dan Tengah', 'PA', NULL, '2018-08-08 18:10:18', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (30, 17, '005011700099329000KD', 'PENGADILAN NEGERI MANADO', 'general', 'Manado', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Manado', 'Kantor Wilayah DJKN Sulawesi Utara, Tengah, Gorontalo Dan Maluku Utara', 'PN', NULL, '2018-08-08 18:10:18', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (31, 17, '005011700099340000KD', 'PENGADILAN NEGERI TAHUNA', 'general', 'Tahuna', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Manado', 'Kantor Wilayah DJKN Sulawesi Utara, Tengah, Gorontalo Dan Maluku Utara', 'PN', NULL, '2018-08-08 18:10:18', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (32, 19, '005011900099528000KD', 'PENGADILAN NEGERI PINRANG', 'general', 'Pinrang', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pare-Pare', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PN', NULL, '2018-08-08 18:10:18', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (33, 19, '005011900099560000KD', 'PENGADILAN NEGERI BANTAENG', 'general', 'Banta Eng', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Makasar', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PN', NULL, '2018-08-08 18:10:18', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (34, 19, '005011900099617000KD', 'PENGADILAN NEGERI MAKALE', 'general', 'Makale', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Palopo', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PN', NULL, '2018-08-08 18:10:18', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (35, 19, '005011900307424000KD', 'PENGADILAN TINGGI AGAMA MAKASSAR', 'tingkatbanding', 'Makassar', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Makasar', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PA', NULL, '2018-08-08 18:10:18', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (36, 19, '005011900307470000KD', 'PENGADILAN AGAMA TAKALAR', 'general', 'Takalar', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Makasar', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PA', NULL, '2018-08-08 18:10:18', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (37, 19, '005011900307597000KD', 'PENGADILAN AGAMA ENREKANG', 'general', 'Enrekang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Palopo', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PA', NULL, '2018-08-08 18:10:18', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (38, 20, '005012000400540000KD', 'PENGADILAN TINGGI KENDARI', 'tingkatbanding', 'Kendari', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kendari', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PN', NULL, '2018-08-08 18:10:18', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (39, 20, '005012000477224000KD', 'PENGADILAN NEGERI UNAAHA', 'general', 'Una Aha', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kendari', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PN', NULL, '2018-08-08 18:10:18', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (40, 21, '005012100539117000KD', 'PENGADILAN TATA USAHA NEGARA AMBON', 'general', 'Ambon', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', 'Kantor Pelayanan Kekayaan Negara dan Lelang Ambon', 'Kantor Wilayah DJKN Papua, Papua Barat Dan Maluku', 'PT', NULL, '2018-08-08 18:10:18', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (41, 22, '005012200099802000KD', 'PENGADILAN NEGERI NEGARA', 'general', 'Negara', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Singaraja', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PN', NULL, '2018-08-08 18:10:18', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (42, 23, '005012300099879000KD', 'PENGADILAN NEGERI KLAS IB RABA BIMA (01)', 'general', 'Raba/Bima', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bima', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PN', NULL, '2018-08-08 18:10:18', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (43, 23, '005012300099905000KD', 'PENGADILAN NEGERI DOMPU (01)', 'general', 'Dompu', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bima', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PN', NULL, '2018-08-08 18:10:18', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (44, 23, '005012300307885000KD', 'PENGADILAN AGAMA MATARAM', 'general', 'Mataram', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Mataram', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PA', NULL, '2018-08-08 18:10:18', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (45, 24, '005012400400157000KD', 'PENGADILAN NEGERI BAJAWA', 'general', 'Bajawa', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kupang', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PN', NULL, '2018-08-08 18:10:18', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (46, 24, '005012400402851000KD', 'PENGADILAN AGAMA MAUMERE', 'general', 'Maumere', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kupang', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PA', NULL, '2018-08-08 18:10:18', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (47, 25, '005012500402860000KD', 'PENGADILAN TINGGI AGAMA JAYAPURA', 'tingkatbanding', 'Jayapura', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jayapura', 'Kantor Wilayah DJKN Papua, Papua Barat Dan Maluku', 'PA', NULL, '2018-08-08 18:10:18', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (48, 26, '005012600308021000KD', 'PENGADILAN AGAMA CURUP', 'general', 'Curup', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bengkulu', 'Kantor Wilayah DJKN Lampung Dan Bengkulu', 'PA', NULL, '2018-08-08 18:10:18', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (49, 26, '005012600400239000KD', 'PENGADILAN NEGERI ARGA MAKMUR', 'general', 'Arga Makmur', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bengkulu', 'Kantor Wilayah DJKN Lampung Dan Bengkulu', 'PN', NULL, '2018-08-08 18:10:18', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (50, 26, '005012600578885000KD', 'PENGADILAN TATA USAHA NEGARA BENGKULU', 'general', 'Bengkulu', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bengkulu', 'Kantor Wilayah DJKN Lampung Dan Bengkulu', 'PT', NULL, '2018-08-08 18:10:18', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (51, 26, '005012600672994000KD', 'PENGADILAN NEGERI BINTUHAN', 'general', 'Bintuhan', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bengkulu', 'Kantor Wilayah DJKN Lampung Dan Bengkulu', 'PN', NULL, '2018-08-08 18:10:18', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (52, 27, '005012800099748000KD', 'PENGADILAN NEGERI TOBELO', 'general', 'Tobelo', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Ternate', 'Kantor Wilayah DJKN Sulawesi Utara, Tengah, Gorontalo Dan Maluku Utara', 'PN', NULL, '2018-08-08 18:10:18', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (53, 29, '005013000400600000KD', 'PENGADILAN NEGERI TANJUNGPANDAN', 'general', 'Tanjung Pandan', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pangkalpinang', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PN', NULL, '2018-08-08 18:10:18', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (54, 31, '005013200672948000KD', 'PENGADILAN NEGERI RANAI [01]', 'general', 'Ranai', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Batam', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PN', NULL, '2018-08-08 18:10:18', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (55, 2, '005010200400710000KD', 'PENGADILAN AGAMA GARUT', 'general', 'Garut', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Tasikmalaya', 'Kantor Wilayah DJKN Jawa Barat', 'PA', NULL, '2018-08-08 22:25:19', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (56, 2, '005010200400848000KD', 'PENGADILAN AGAMA KARAWANG', 'general', 'Karawang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Purwakarta', 'Kantor Wilayah DJKN Jawa Barat', 'PA', NULL, '2018-08-08 22:25:19', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (57, 2, '005010200403009000KD', 'PENGADILAN AGAMA SUMBER', 'general', 'Sumber', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Cirebon', 'Kantor Wilayah DJKN Jawa Barat', 'PA', NULL, '2018-08-08 22:25:19', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (58, 2, '005010200613519000KD', 'PENGADILAN NEGERI CIBINONG', 'general', 'Kab.Bogor Di Cibinong', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bogor', 'Kantor Wilayah DJKN Jawa Barat', 'PN', NULL, '2018-08-08 22:25:19', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (59, 2, '005010200652062000KD', 'PENGADILAN AGAMA DEPOK', 'general', 'Depok', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bogor', 'Kantor Wilayah DJKN Jawa Barat', 'PA', NULL, '2018-08-08 22:25:19', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (60, 3, '005010300097819000KD', 'PENGADILAN NEGERI PURWODADI', 'general', 'Purwodadi', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Semarang', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PN', NULL, '2018-08-08 22:25:19', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (61, 3, '005010300097851000KD', 'PENGADILAN NEGERI BLORA', 'general', 'Blora', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Semarang', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PN', NULL, '2018-08-08 22:25:19', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (62, 3, '005010300400891000KD', 'PENGADILAN AGAMA BREBES', 'general', 'Brebes', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Tegal', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2018-08-08 22:25:19', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (63, 3, '005010300400973000KD', 'Pengadilan Agama Kudus', 'general', 'Kudus', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Semarang', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2018-08-08 22:25:19', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (64, 3, '005010300401055000KD', 'PENGADILAN AGAMA KEBUMEN', 'general', 'Kebumen', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Purwokerto', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2018-08-08 22:25:19', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (65, 3, '005010300401061000KD', 'PENGADILAN AGAMA PURWOKERTO 01', 'general', 'Purwokerto', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Purwokerto', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2018-08-08 22:25:19', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (66, 3, '005010300401143000KD', 'PENGADILAN AGAMA SRAGEN', 'general', 'Sragen', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Surakarta', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2018-08-08 22:25:19', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (67, 3, '005010300401174000KD', 'PENGADILAN AGAMA KARANGANYAR', 'general', 'Karanganyar', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Surakarta', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2018-08-08 22:25:19', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (68, 3, '005010300531830000KD', 'PENGADILAN TATA USAHA NEGARA SEMARANG', 'general', 'Semarang', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', 'Kantor Pelayanan Kekayaan Negara dan Lelang Semarang', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PT', NULL, '2018-08-08 22:25:19', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (69, 4, '005010400401225000KD', 'PENGADILAN AGAMA BANTUL', 'general', 'Bantul', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Yogyakarta', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2018-08-08 22:25:19', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (70, 4, '005010400578801000KD', 'PENGADILAN TATA USAHA NEGARA YOGYAKARTA', 'general', 'Yogyakarta', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', 'Kantor Pelayanan Kekayaan Negara dan Lelang Yogyakarta', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PT', NULL, '2018-08-08 22:25:19', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (71, 5, '005010500098146000KD', 'PN LAMONGAN_01', 'general', 'Lamongan', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Surabaya', 'Kantor Wilayah DJKN Jawa Timur', 'PN', NULL, '2018-08-08 22:25:19', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (72, 6, '005010600098441000KD', 'PENGADILAN NEGERI/PHI/TIPIKOR BANDA ACEH', 'general', 'Banda Aceh', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banda Aceh', 'Kantor Wilayah DJKN Aceh', 'PN', NULL, '2018-08-08 22:25:19', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (73, 6, '005010600098590000KD', 'PENGADILAN NEGERI TAPAKTUAN', 'general', 'Tapak Tuan', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banda Aceh', 'Kantor Wilayah DJKN Aceh', 'PN', NULL, '2018-08-08 22:25:19', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (74, 7, '005010700477399000KD', 'PENGADILAN NEGERI MANDAILING NATAL', 'general', 'Mandailing Natal', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Padangsidimpuan', 'Kantor Wilayah DJKN Sumatera Utara', 'PN', NULL, '2018-08-08 22:25:19', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (75, 8, '005010800401947000KD', 'PENGADILAN AGAMA BATUSANGKAR KELAS IB', 'general', 'Batusangkar', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bukittinggi', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PA', NULL, '2018-08-08 22:25:19', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (76, 9, '005010900402622000KD', 'PENGADILAN AGAMA DUMAI', 'general', 'Dumai', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Dumai', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PA', NULL, '2018-08-08 22:25:19', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (77, 9, '005010900631999000KD', 'PENGADILAN AGAMA PANGKALAN KERINCI', 'general', 'Pangkalan Kerinci', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pekanbaru', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PA', NULL, '2018-08-08 22:25:19', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (78, 10, '005011000400430000KD', 'PENGADILAN NEGERI MUARA BULIAN', 'general', 'Muara Bulian', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jambi', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PN', NULL, '2018-08-08 22:25:19', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (79, 10, '005011000402191000KD', 'PENGADILAN AGAMA MUARA BUNGO', 'general', 'Muara Bungo', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jambi', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PA', NULL, '2018-08-08 22:25:19', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (80, 10, '005011000403052000KD', 'PENGADILAN AGAMA MUARA BULIAN', 'general', 'Muara Bulian', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jambi', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PA', NULL, '2018-08-08 22:25:19', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (81, 11, '005011100099003000KD', 'PENGADILAN NEGERI SEKAYU', 'general', 'Sekayu', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Palembang', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PN', NULL, '2018-08-08 22:25:19', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (82, 11, '005011100402242000KD', 'PENGADILAN AGAMA PALEMBANG', 'general', 'Palembang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Palembang', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PA', NULL, '2018-08-08 22:25:19', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (83, 12, '005011200099045000KD', 'Pengadilan Negeri Metro', 'general', 'Metro', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Metro', 'Kantor Wilayah DJKN Lampung Dan Bengkulu', 'PN', NULL, '2018-08-08 22:25:19', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (84, 12, '005011200547678000KD', 'PTA BANDAR LAMPUNG', 'general', 'Bandar Lampung', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bandar Lampung', 'Kantor Wilayah DJKN Lampung Dan Bengkulu', 'PA', NULL, '2018-08-08 22:25:19', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (85, 12, '005011200652055000KD', 'PA. BLAMBANGAN UMPU 01', 'general', 'Blambangan Umpu', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Metro', 'Kantor Wilayah DJKN Lampung Dan Bengkulu', 'PA', NULL, '2018-08-08 22:25:19', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (86, 13, '005011300099066000KD', 'Pengadilan Negeri Pontianak', 'general', 'Pontianak', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pontianak', 'Kantor Wilayah DJKN Kalimantan Barat', 'PN', NULL, '2018-08-08 22:25:19', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (87, 13, '005011300670227000KD', 'PENGADILAN NEGERI SAMBAS (01)', 'general', 'Sambas', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Singkawang', 'Kantor Wilayah DJKN Kalimantan Barat', 'PN', NULL, '2018-08-08 22:25:19', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (88, 14, '005011400672973000KD', 'PENGADILAN NEGERI KASONGAN', 'general', 'Kasongan', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Palangkaraya', 'Kantor Wilayah DJKN Kalimantan Selatan Dan Tengah', 'PN', NULL, '2018-08-08 22:25:19', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (89, 15, '005011500099230000KD', 'PN MARTAPURA', 'general', 'Martapura', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banjarmasin', 'Kantor Wilayah DJKN Kalimantan Selatan Dan Tengah', 'PN', NULL, '2018-08-08 22:25:19', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (90, 15, '005011500099244000KD', 'PN TANJUNG', 'general', 'Tanjung', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banjarmasin', 'Kantor Wilayah DJKN Kalimantan Selatan Dan Tengah', 'PN', NULL, '2018-08-08 22:25:19', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (91, 15, '005011500402500000KD', 'PENGADILAN AGAMA BANJARMASIN', 'general', 'Banjarmasin', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banjarmasin', 'Kantor Wilayah DJKN Kalimantan Selatan Dan Tengah', 'PA', NULL, '2018-08-08 22:25:19', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (92, 15, '005011500402531000KD', 'PENGADILAN AGAMA KANDANGAN', 'general', 'Kandangan', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banjarmasin', 'Kantor Wilayah DJKN Kalimantan Selatan Dan Tengah', 'PA', NULL, '2018-08-08 22:25:19', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (93, 15, '005011500402556000KD', 'PENGADILAN AGAMA AMUNTAI', 'general', 'Amuntai', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banjarmasin', 'Kantor Wilayah DJKN Kalimantan Selatan Dan Tengah', 'PA', NULL, '2018-08-08 22:25:19', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (94, 16, '005011600400291000KD', 'PENGADILAN NEGERI TANJUNG REDEB', 'general', 'Tanjung Redep', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Tarakan', 'Kantor Wilayah DJKN Kalimantan Timur Dan Utara', 'PN', NULL, '2018-08-08 22:25:19', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (95, 16, '005011600559857000KD', 'PENGADILAN TATA USAHA NEGARA SAMARINDA', 'general', 'Samarinda', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', 'Kantor Pelayanan Kekayaan Negara dan Lelang Samarinda', 'Kantor Wilayah DJKN Kalimantan Timur Dan Utara', 'PT', NULL, '2018-08-08 22:25:19', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (96, 16, '005011600662986000KD', 'PENGADILAN NEGERI SANGATTA', 'general', 'Sangatta', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bontang', 'Kantor Wilayah DJKN Kalimantan Timur Dan Utara', 'PN', NULL, '2018-08-08 22:25:19', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (97, 17, '005011700531872000KD', 'PTUN MANADO', 'general', 'Manado', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', 'Kantor Pelayanan Kekayaan Negara dan Lelang Manado', 'Kantor Wilayah DJKN Sulawesi Utara, Tengah, Gorontalo Dan Maluku Utara', 'PT', NULL, '2018-08-08 22:25:19', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (98, 19, '005011900099464000KD', 'PENGADILAN NEGERI TAKALAR', 'general', 'Takalar', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Makasar', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PN', NULL, '2018-08-08 22:25:19', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (99, 19, '005011900307445000KD', 'PENGADILAN AGAMA MAROS', 'general', 'Maros', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Makasar', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PA', NULL, '2018-08-08 22:25:19', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (100, 19, '005011900307452000KD', 'UAKPB PENGADILAN AGAMA MAKASSAR', 'general', 'Ujung Pandang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Makasar', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PA', NULL, '2018-08-08 22:25:19', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (101, 19, '005011900673013000KD', 'PENGADILAN NEGERI MALILI', 'general', 'Malili', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Palopo', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PN', NULL, '2018-08-08 22:25:19', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (102, 22, '005012200099858000KD', 'PENGADILAN NEGERI BANGLI', 'general', 'Bangli', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Singaraja', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PN', NULL, '2018-08-08 22:25:19', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (103, 22, '005012200402772000KD', 'PENGADILAN AGAMA GIANYAR', 'general', 'Gianyar', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Denpasar', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PA', NULL, '2018-08-08 22:25:19', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (104, 23, '005012300307892000KD', 'PENGADILAN AGAMA SUMBAWA BESAR (01)', 'general', 'Sumbawa', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bima', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PA', NULL, '2018-08-08 22:25:19', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (105, 23, '005012300614727000KD', 'PA GIRI MENANG', 'general', 'Giri Menang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Mataram', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PA', NULL, '2018-08-08 22:25:19', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (106, 25, '005012500400276000KD', 'PENGADILAN NEGERI SERUI (01)', 'general', 'Serui', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Biak', 'Kantor Wilayah DJKN Papua, Papua Barat Dan Maluku', 'PN', NULL, '2018-08-08 22:25:19', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (107, 25, '005012500402927000KD', 'PENGADILAN AGAMA NABIRE', 'general', 'Nabire', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Biak', 'Kantor Wilayah DJKN Papua, Papua Barat Dan Maluku', 'PA', NULL, '2018-08-08 22:25:19', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (108, 29, '005013000403092000KD', 'PENGADILAN AGAMA SUNGAILIAT', 'general', 'Sungai Liat', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pangkalpinang', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PA', NULL, '2018-08-08 22:25:19', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (109, 30, '005013100400208000KD', 'PENGADILAN NEGERI LIMBOTO', 'general', 'Limboto', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Gorontalo', 'Kantor Wilayah DJKN Sulawesi Utara, Tengah, Gorontalo Dan Maluku Utara', 'PN', NULL, '2018-08-08 22:25:19', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (110, 32, '005013300400069000KD', 'PENGADILAN NEGERI MANOKWARI', 'general', 'Manokwari', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Sorong', 'Kantor Wilayah DJKN Papua, Papua Barat Dan Maluku', 'PN', NULL, '2018-08-08 22:25:19', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (111, 33, '005013400099638000KD', 'PENGADILAN NEGERI MAMUJU', 'general', 'Mamuju', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Mamuju', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PN', NULL, '2018-08-08 22:25:19', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (112, 1, '005010100097467000KD', 'PENGADILAN TINGGI JAKARTA', 'tingkatbanding', 'Jakarta', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jakarta I', 'Kantor Wilayah DJKN DKI Jakarta', 'PN', NULL, '2018-08-09 00:04:07', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (113, 1, '005010100097471000KD', 'PENGADILAN NEGERI JAKARTA PUSAT', 'general', 'Jakarta Pusat', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jakarta I', 'Kantor Wilayah DJKN DKI Jakarta', 'PN', NULL, '2018-08-09 00:04:07', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (114, 1, '005010100097488000KD', 'PENGADILAN NEGERI JAKARTA BARAT', 'general', 'Jakarta Barat', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jakarta I', 'Kantor Wilayah DJKN DKI Jakarta', 'PN', NULL, '2018-08-09 00:04:07', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (115, 1, '005010100097492000KD', 'PENGADILAN NEGERI JAKARTA TIMUR', 'general', 'Jakarta Timur', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jakarta I', 'Kantor Wilayah DJKN DKI Jakarta', 'PN', NULL, '2018-08-09 00:04:07', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (116, 1, '005010100400214000KD', 'PENGADILAN NEGERI JAKARTA SELATAN', 'general', 'Jakarta Selatan', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jakarta I', 'Kantor Wilayah DJKN DKI Jakarta', 'PN', NULL, '2018-08-09 00:04:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (117, 1, '005010100400220000KD', 'PENGADILAN NEGERI JAKARTA UTARA', 'general', 'Jakarta Utara', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jakarta I', 'Kantor Wilayah DJKN DKI Jakarta', 'PN', NULL, '2018-08-09 00:04:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (118, 1, '005010100400616000KD', 'PENGADILAN AGAMA JAKARTA PUSAT', 'general', 'Jakarta Pusat', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jakarta I', 'Kantor Wilayah DJKN DKI Jakarta', 'PA', NULL, '2018-08-09 00:04:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (119, 1, '005010100400622000KD', 'PENGADILAN AGAMA JAKARTA UTARA', 'general', 'Jakarta Utara', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jakarta I', 'Kantor Wilayah DJKN DKI Jakarta', 'PA', NULL, '2018-08-09 00:04:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (120, 1, '005010100400631000KD', 'PENGADILAN AGAMA JAKARTA BARAT', 'general', 'Jakarta Barat', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jakarta I', 'Kantor Wilayah DJKN DKI Jakarta', 'PA', NULL, '2018-08-09 00:04:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (121, 1, '005010100400647000KD', 'PENGADILAN AGAMA JAKARTA TIMUR', 'general', 'Jakarta Timur', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jakarta I', 'Kantor Wilayah DJKN DKI Jakarta', 'PA', NULL, '2018-08-09 00:04:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (122, 1, '005010100400653000KD', 'PENGADILAN AGAMA JAKARTA SELATAN', 'general', 'Jakarta Selatan', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jakarta I', 'Kantor Wilayah DJKN DKI Jakarta', 'PA', NULL, '2018-08-09 00:04:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (123, 1, '005010100401112000KD', 'PENGADILAN TINGGI AGAMA DKI JAKARTA', 'tingkatbanding', 'Jakarta', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jakarta I', 'Kantor Wilayah DJKN DKI Jakarta', 'PA', NULL, '2018-08-09 00:04:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (124, 1, '005010100526704000KD', 'PENGADILAN TINGGI TATA USAHA NEGARA JAKARTA', 'tingkatbanding', 'Jakarta', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jakarta I', 'Kantor Wilayah DJKN DKI Jakarta', 'PT', NULL, '2018-08-09 00:04:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (125, 1, '005010100526732000KD', 'PENGADILAN TUN JAKARTA', 'general', 'Jakarta', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jakarta I', 'Kantor Wilayah DJKN DKI Jakarta', 'PT', NULL, '2018-08-09 00:04:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (126, 1, '005010100663161000KD', 'PENGADILAN MILITER UTAMA', 'general', 'Jakarta', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jakarta I', 'Kantor Wilayah DJKN DKI Jakarta', 'PM', NULL, '2018-08-09 00:04:07', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (127, 1, '005010100663250000KD', 'PENGADILAN MILITER TINGGI II JAKARTA (01)', 'tingkatbanding', 'Jakarta', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jakarta I', 'Kantor Wilayah DJKN DKI Jakarta', 'PM', NULL, '2018-08-09 00:04:07', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (128, 1, '005010100663267000KD', 'PENGADILAN MILITER II-08 JAKARTA', 'general', 'Jakarta', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jakarta I', 'Kantor Wilayah DJKN DKI Jakarta', 'PM', NULL, '2018-08-09 00:04:07', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (129, 2, '005010200097500000KD', 'PENGADILAN TINGGI BANDUNG (01)', 'tingkatbanding', 'Bandung', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bandung', 'Kantor Wilayah DJKN Jawa Barat', 'PN', NULL, '2018-08-09 00:04:07', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (130, 2, '005010200097514000KD', 'PENGADILAN NEGERI BANDUNG (01)', 'general', 'Bandung', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bandung', 'Kantor Wilayah DJKN Jawa Barat', 'PN', NULL, '2018-08-09 00:04:07', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (131, 2, '005010200097521000KD', 'PENGADILAN NEGERI SUMEDANG (01)', 'general', 'Sumedang', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bandung', 'Kantor Wilayah DJKN Jawa Barat', 'PN', NULL, '2018-08-09 00:04:07', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (132, 2, '005010200097535000KD', 'PENGADILAN NEGERI TASIKMALAYA', 'general', 'Tasikmalaya', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Tasikmalaya', 'Kantor Wilayah DJKN Jawa Barat', 'PN', NULL, '2018-08-09 00:04:07', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (133, 2, '005010200097542000KD', 'PENGADILAN NEGERI GARUT', 'general', 'Garut', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Tasikmalaya', 'Kantor Wilayah DJKN Jawa Barat', 'PN', NULL, '2018-08-09 00:04:07', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (134, 2, '005010200097556000KD', 'PENGADILAN NEGERI CIAMIS', 'general', 'Ciamis', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Tasikmalaya', 'Kantor Wilayah DJKN Jawa Barat', 'PN', NULL, '2018-08-09 00:04:07', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (135, 2, '005010200097603000KD', 'PENGADILAN NEGERI PURWAKARTA', 'general', 'Purwakarta', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Purwakarta', 'Kantor Wilayah DJKN Jawa Barat', 'PN', NULL, '2018-08-09 00:04:07', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (136, 2, '005010200097610000KD', 'PENGADILAN NEGERI BEKASI[01]', 'general', 'Bekasi', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bekasi', 'Kantor Wilayah DJKN Jawa Barat', 'PN', NULL, '2018-12-05 19:50:06', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (137, 2, '005010200097624000KD', 'PENGADILAN NEGERI KARAWANG', 'general', 'Karawang', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Purwakarta', 'Kantor Wilayah DJKN Jawa Barat', 'PN', NULL, '2018-12-05 19:50:06', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (138, 2, '005010200097631000KD', 'PENGADILAN NEGERI SUBANG', 'general', 'Subang', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Purwakarta', 'Kantor Wilayah DJKN Jawa Barat', 'PN', NULL, '2018-12-05 19:50:06', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (139, 2, '005010200097645000KD', 'PENGADILAN NEGERI BOGOR', 'general', 'Bogor', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bogor', 'Kantor Wilayah DJKN Jawa Barat', 'PN', NULL, '2018-12-05 19:50:06', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (140, 2, '005010200097652000KD', 'PENGADILAN NEGERI SUKABUMI (BUA)', 'general', 'Sukabumi', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bogor', 'Kantor Wilayah DJKN Jawa Barat', 'PN', NULL, '2018-12-05 19:50:06', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (141, 2, '005010200097670000KD', 'PENGADILAN NEGERI CIREBON', 'general', 'Cirebon', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Cirebon', 'Kantor Wilayah DJKN Jawa Barat', 'PN', NULL, '2018-12-05 19:50:06', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (142, 2, '005010200097687000KD', 'PENGADILAN NEGERI INDRAMAYU', 'general', 'Indramayu', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Cirebon', 'Kantor Wilayah DJKN Jawa Barat', 'PN', NULL, '2018-12-05 19:50:06', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (143, 2, '005010200097691000KD', 'PENGADILAN NEGERI MAJALENGKA', 'general', 'Majalengka', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Cirebon', 'Kantor Wilayah DJKN Jawa Barat', 'PN', NULL, '2018-12-05 19:50:06', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (144, 2, '005010200097709000KD', 'PN KUNINGAN', 'general', 'Kuningan', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Cirebon', 'Kantor Wilayah DJKN Jawa Barat', 'PN', NULL, '2018-12-05 19:50:06', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (145, 2, '005010200308166000KD', 'PENGADILAN TINGGI AGAMA BANDUNG (01)', 'tingkatbanding', 'Bandung', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bandung', 'Kantor Wilayah DJKN Jawa Barat', 'PA', NULL, '2018-12-05 19:50:06', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (146, 2, '005010200400409000KD', 'PENGADILAN NEGERI CIBADAK', 'general', 'Cibadak', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bogor', 'Kantor Wilayah DJKN Jawa Barat', 'PN', NULL, '2018-12-05 19:50:06', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (147, 2, '005010200400477000KD', 'Pengadilan Negeri Sumber', 'general', 'Sumber', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Cirebon', 'Kantor Wilayah DJKN Jawa Barat', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (148, 2, '005010200400483000KD', 'PENGADILAN NEGERI BALE BANDUNG', 'general', 'Bale Bandung', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bandung', 'Kantor Wilayah DJKN Jawa Barat', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (149, 2, '005010200400662000KD', 'PENGADILAN AGAMA BANDUNG (01)', 'general', 'Bandung', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bandung', 'Kantor Wilayah DJKN Jawa Barat', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (150, 2, '005010200400678000KD', 'PENGADILAN AGAMA SUMEDANG (01)', 'general', 'Sumedang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bandung', 'Kantor Wilayah DJKN Jawa Barat', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (151, 2, '005010200400684000KD', 'PENGADILAN AGAMA CIMAHI (01)', 'general', 'Cimahi', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bandung', 'Kantor Wilayah DJKN Jawa Barat', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (152, 2, '005010200400690000KD', 'PENGADILAN AGAMA CIAMIS', 'general', 'Ciamis', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Tasikmalaya', 'Kantor Wilayah DJKN Jawa Barat', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (153, 2, '005010200400704000KD', 'PENGADILAN AGAMA TASIKMALAYA', 'general', 'Tasikmalaya', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Tasikmalaya', 'Kantor Wilayah DJKN Jawa Barat', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (154, 2, '005010200400729000KD', 'PENGADILAN AGAMA BOGOR', 'general', 'Bogor', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bogor', 'Kantor Wilayah DJKN Jawa Barat', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (155, 2, '005010200400735000KD', 'PENGADILAN AGAMA SUKABUMI', 'general', 'Sukabumi', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bogor', 'Kantor Wilayah DJKN Jawa Barat', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (156, 2, '005010200400741000KD', 'PENGADILAN AGAMA CIANJUR', 'general', 'Cianjur', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bogor', 'Kantor Wilayah DJKN Jawa Barat', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (157, 2, '005010200400750000KD', 'PENGADILAN AGAMA CIREBON', 'general', 'Cirebon', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Cirebon', 'Kantor Wilayah DJKN Jawa Barat', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (158, 2, '005010200400772000KD', 'PENGADILAN AGAMA MAJALENGKA', 'general', 'Majalengka', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Cirebon', 'Kantor Wilayah DJKN Jawa Barat', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (159, 2, '005010200400781000KD', 'PENGADILAN AGAMA KUNINGAN', 'general', 'Kuningan', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Cirebon', 'Kantor Wilayah DJKN Jawa Barat', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (160, 2, '005010200400832000KD', 'PENGADILAN AGAMA BEKASI', 'general', 'Bekasi', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bekasi', 'Kantor Wilayah DJKN Jawa Barat', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (161, 2, '005010200400854000KD', 'PENGADILAN AGAMA PURWAKARTA', 'general', 'Purwakarta', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Purwakarta', 'Kantor Wilayah DJKN Jawa Barat', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (162, 2, '005010200402587000KD', 'PENGADILAN AGAMA SUBANG', 'general', 'Subang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Purwakarta', 'Kantor Wilayah DJKN Jawa Barat', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (163, 2, '005010200402995000KD', 'PENGADILAN AGAMA CIBADAK', 'general', 'Cibadak', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bogor', 'Kantor Wilayah DJKN Jawa Barat', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (164, 2, '005010200477292000KD', 'PENGADILAN NEGERI DEPOK', 'general', 'Depok', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bogor', 'Kantor Wilayah DJKN Jawa Barat', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (165, 2, '005010200531823000KD', 'PTUN BANDUNG (01)', 'general', 'Bandung', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bandung', 'Kantor Wilayah DJKN Jawa Barat', 'PT', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (166, 2, '005010200604719000KD', 'PENGADILAN AGAMA CIBINONG', 'general', 'Cibinong', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bogor', 'Kantor Wilayah DJKN Jawa Barat', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (167, 2, '005010200614706000KD', 'PENGADILAN AGAMA CIKARANG', 'general', 'Cikarang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bekasi', 'Kantor Wilayah DJKN Jawa Barat', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (168, 2, '005010200663271000KD', 'PENGADILAN MILITER II-09 BANDUNG', 'general', 'Bandung', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bandung', 'Kantor Wilayah DJKN Jawa Barat', 'PM', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (169, 2, '005010200682150000KD', 'PENGADILAN AGAMA KOTA TASIKMALAYA', 'general', 'Kota Tasikmalaya', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Tasikmalaya', 'Kantor Wilayah DJKN Jawa Barat', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (170, 2, '005010200682164000KD', 'PENGADILAN AGAMA KOTA BANJAR', 'general', 'Kota Banjar', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Tasikmalaya', 'Kantor Wilayah DJKN Jawa Barat', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (171, 3, '005010300097713000KD', 'PENGADILAN TINGGI JAWA TENGAH', 'tingkatbanding', 'Semarang', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Semarang', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (172, 3, '005010300097720000KD', 'PENGADILAN NEGERI SEMARANG', 'general', 'Semarang', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Semarang', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (173, 3, '005010300097734000KD', 'PENGADILAN NEGERI TEGAL', 'general', 'Tegal', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Tegal', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (174, 3, '005010300097741000KD', 'PENGADILAN NEGERI PEKALONGAN', 'general', 'Pekalongan', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pekalongan', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (175, 3, '005010300097755000KD', 'PENGADILAN NEGERI KUDUS', 'general', 'Kudus', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Semarang', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (176, 3, '005010300097762000KD', 'PENGADILAN NEGERI PATI', 'general', 'Pati', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Semarang', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (177, 3, '005010300097776000KD', 'PN BREBES (01)', 'general', 'Brebes', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Tegal', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (178, 3, '005010300097780000KD', 'PN PEMALANG (01)', 'general', 'Pemalang', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Tegal', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (179, 3, '005010300097797000KD', 'PENGADILAN NEGERI KENDAL', 'general', 'Kendal', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pekalongan', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (180, 3, '005010300097802000KD', 'PENGADILAN NEGERI DEMAK', 'general', 'Demak', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Semarang', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (181, 3, '005010300097823000KD', 'PENGADILAN NEGERI SALATIGA', 'general', 'Salatiga', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Semarang', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (182, 3, '005010300097830000KD', 'PENGADILAN NEGERI UNGARAN', 'general', 'Kabupaten Semarang Di Ungaran', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Semarang', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (183, 3, '005010300097844000KD', 'PN JEPARA', 'general', 'Jepara', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Semarang', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (184, 3, '005010300097865000KD', 'PENGADILAN NEGERI REMBANG', 'general', 'Rembang', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Semarang', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (185, 3, '005010300097872000KD', 'PENGADILAN NEGERI BATANG', 'general', 'Batang', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pekalongan', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (186, 3, '005010300097886000KD', 'PENGADILAN NEGERI PURWOREJO', 'general', 'Purworejo', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Purwokerto', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (187, 3, '005010300097890000KD', 'PENGADILAN NEGERI MAGELANG', 'general', 'Magelang', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Semarang', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (188, 3, '005010300097908000KD', 'PENGADILAN NEGERI KEBUMEN', 'general', 'Kebumen', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Purwokerto', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (189, 3, '005010300097912000KD', 'PENGADILAN NEGERI TEMANGGUNG', 'general', 'Temanggung', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Semarang', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (190, 3, '005010300097929000KD', 'PENGADILAN NEGERI WONOSOBO', 'general', 'Wonosobo', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Purwokerto', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (191, 3, '005010300097933000KD', 'PENGADILAN NEGERI SURAKARTA', 'general', 'Surakarta', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Surakarta', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (192, 3, '005010300097940000KD', 'PENGADILAN NEGERI  SRAGEN KELAS I A', 'general', 'Sragen', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Surakarta', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (193, 3, '005010300097954000KD', 'PENGADILAN NEGERI WONOGIRI', 'general', 'Wonogiri', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Surakarta', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (194, 3, '005010300097961000KD', 'PENGADILAN NEGERI SUKOHARJO', 'general', 'Sukoharjo', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Surakarta', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (195, 3, '005010300097975000KD', 'PENGADILAN NEGERI KARANGANYAR', 'general', 'Karangayar', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Surakarta', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (196, 3, '005010300097996000KD', 'PENGADILAN NEGERI KLATEN', 'general', 'Klaten', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Surakarta', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (197, 3, '005010300098001000KD', 'PENGADILAN NEGERI PURWOKERTO', 'general', 'Purwokerto', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Purwokerto', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (198, 3, '005010300098015000KD', 'PENGADILAN NEGERI CILACAP', 'general', 'Cilacap', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Purwokerto', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (199, 3, '005010300098022000KD', 'PENGADILAN NEGERI BANYUMAS', 'general', 'Banyumas', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Purwokerto', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (200, 3, '005010300098036000KD', 'PENGADILAN NEGERI PURBALINGGA', 'general', 'Purbalingga', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Purwokerto', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (201, 3, '005010300098040000KD', 'PENGADILAN NEGERI BANJARNEGARA', 'general', 'Banjarnegara', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Purwokerto', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (202, 3, '005010300400565000KD', 'PENGADILAN NEGERI SLAWI', 'general', 'Kabupaten Tegal Di Slawi', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Tegal', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (203, 3, '005010300400571000KD', 'PENGADILAN NEGERI MUNGKID', 'general', 'Kabupaten Magelang Di Mungkid', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Semarang', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (204, 3, '005010300400860000KD', 'PENGADILAN AGAMA PEKALONGAN', 'general', 'Pekalongan', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pekalongan', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (205, 3, '005010300400879000KD', 'PA PEMALANG (01)', 'general', 'Pemalang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Tegal', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (206, 3, '005010300400885000KD', 'PENGADILAN AGAMA TEGAL (01)', 'general', 'Tegal', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Tegal', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (207, 3, '005010300400905000KD', 'PENGADILAN AGAMA BATANG', 'general', 'Batang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pekalongan', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (208, 3, '005010300400911000KD', 'PENGADILAN AGAMA KELAS I-A SEMARANG', 'general', 'Semarang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Semarang', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (209, 3, '005010300400920000KD', 'PENGADILAN AGAMA SALATIGA', 'general', 'Salatiga', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Semarang', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (210, 3, '005010300400936000KD', 'PENGADILAN AGAMA KENDAL KELAS I-A', 'general', 'Kendal', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pekalongan', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (211, 3, '005010300400942000KD', 'PENGADILAN AGAMA DEMAK', 'general', 'Demak', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Semarang', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (212, 3, '005010300400951000KD', 'PENGADILAN AGAMA PURWODADI', 'general', 'Purwodadi', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Semarang', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (213, 3, '005010300400967000KD', 'PENGADILAN AGAMA PATI', 'general', 'Pati', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Semarang', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (214, 3, '005010300400982000KD', 'PENGADILAN AGAMA JEPARA', 'general', 'Jepara', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Semarang', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (215, 3, '005010300400998000KD', 'PENGADILAN AGAMA REMBANG', 'general', 'Rembang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Semarang', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (216, 3, '005010300401002000KD', 'PENGADILAN AGAMA BLORA', 'general', 'Blora', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Semarang', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (217, 3, '005010300401018000KD', 'PA MAGELANG', 'general', 'Magelang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Semarang', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (218, 3, '005010300401030000KD', 'PENGADILAN AGAMA WONOSOBO', 'general', 'Wonosobo', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Purwokerto', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (219, 3, '005010300401049000KD', 'PENGADILAN AGAMA PURWOREJO', 'general', 'Purworejo', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Purwokerto', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (220, 3, '005010300401070000KD', 'PENGADILAN AGAMA BANYUMAS', 'general', 'Banyumas', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Purwokerto', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (221, 3, '005010300401086000KD', 'PENGADILAN AGAMA CILACAP', 'general', 'Cilacap', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Purwokerto', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (222, 3, '005010300401092000KD', 'PENGADILAN AGAMA PURBALINGGA', 'general', 'Purbalingga', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Purwokerto', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (223, 3, '005010300401106000KD', 'PENGADILAN AGAMA BANJARNEGARA', 'general', 'Banjarnegara', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Purwokerto', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (224, 3, '005010300401121000KD', 'PENGADILAN AGAMA KLATEN', 'general', 'Klaten', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Surakarta', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (225, 3, '005010300401137000KD', 'PENGADILAN AGAMA BOYOLALI', 'general', 'Boyolali', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Surakarta', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (226, 3, '005010300401152000KD', 'PENGADILAN AGAMA WONOGIRI', 'general', 'Wonogiri', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Surakarta', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (227, 3, '005010300401180000KD', 'PENGADILAN AGAMA SURAKARTA', 'general', 'Surakarta', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Surakarta', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (228, 3, '005010300402593000KD', 'PENGADILAN AGAMA AMBARAWA', 'general', 'Ambarawa', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Semarang', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (229, 3, '005010300402964000KD', 'PENGADILAN TINGGI AGAMA SEMARANG', 'tingkatbanding', 'Semarang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Semarang', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (230, 3, '005010300403015000KD', 'PENGADILAN AGAMA SLAWI (01)', 'general', 'Slawi', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Tegal', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (231, 3, '005010300403021000KD', 'PENGADILAN AGAMA MUNGKID', 'general', 'Mungkid', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Semarang', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (232, 3, '005010300614710000KD', 'PENGADILAN AGAMA KAJEN', 'general', 'Kajen', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pekalongan', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (233, 3, '005010300663288000KD', 'PENGADILAN MILITER II-10 SEMARANG', 'general', 'Semarang', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', 'Kantor Pelayanan Kekayaan Negara dan Lelang Semarang', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PM', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (234, 4, '005010400098057000KD', 'PENGADILAN NEGERI YOGYAKARTA', 'general', 'Yogyakarta', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Yogyakarta', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (235, 4, '005010400098061000KD', 'PENGADILAN NEGERI WATES', 'general', 'Wates', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Yogyakarta', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (236, 4, '005010400098078000KD', 'PENGADILAN NEGERI WONOSARI', 'general', 'Wonosari', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Yogyakarta', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (237, 4, '005010400098082000KD', 'PENGADILAN NEGERI SLEMAN', 'general', 'Sleman', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Yogyakarta', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (238, 4, '005010400400172000KD', 'PENGADILAN NEGERI BANTUL', 'general', 'Bantul', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Yogyakarta', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (239, 4, '005010400401199000KD', 'PA.YOGYAKARTA', 'general', 'Yogyakarta', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Yogyakarta', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (240, 4, '005010400401200000KD', 'PENGADILAN AGAMA SLEMAN', 'general', 'Sleman', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Yogyakarta', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (241, 4, '005010400401219000KD', 'PENGADILAN AGAMA WATES', 'general', 'Wates', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Yogyakarta', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (242, 4, '005010400401231000KD', 'PENGADILAN AGAMA WONOSARI', 'general', 'Wonosari', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Yogyakarta', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (243, 4, '005010400663292000KD', 'PENGADILAN MILITER II-11 YOGYAKARTA', 'general', 'Yogyakarta', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', 'Kantor Pelayanan Kekayaan Negara dan Lelang Yogyakarta', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PM', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (244, 5, '005010500098104000KD', 'PENGADILAN TINGGI SURABAYA', 'tingkatbanding', 'Surabaya', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Surabaya', 'Kantor Wilayah DJKN Jawa Timur', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (245, 5, '005010500098125000KD', 'PN BOJONEGORO', 'general', 'Bojonegoro', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Surabaya', 'Kantor Wilayah DJKN Jawa Timur', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (246, 5, '005010500098132000KD', 'PENGADILAN NEGERI TUBAN', 'general', 'Tuban', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Surabaya', 'Kantor Wilayah DJKN Jawa Timur', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (247, 5, '005010500098150000KD', 'PN GRESIK 01', 'general', 'Gresik', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Surabaya', 'Kantor Wilayah DJKN Jawa Timur', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (248, 5, '005010500098167000KD', 'PENGADILAN NEGERI SIDOARJO', 'general', 'Sidoarjo', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Sidoarjo', 'Kantor Wilayah DJKN Jawa Timur', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (249, 5, '005010500098171000KD', 'PN MOJOKERTO', 'general', 'Mojokerto', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Sidoarjo', 'Kantor Wilayah DJKN Jawa Timur', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (250, 5, '005010500098188000KD', 'PENGADILAN NEGERI JOMBANG', 'general', 'Jombang', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Malang', 'Kantor Wilayah DJKN Jawa Timur', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (251, 5, '005010500098214000KD', 'PENGADILAN NEGERI BANYUWANGI', 'general', 'Banyuwangi', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jember', 'Kantor Wilayah DJKN Jawa Timur', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (252, 5, '005010500098221000KD', 'PENGADILAN NEGERI SITUBONDO 01', 'general', 'Situbondo', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jember', 'Kantor Wilayah DJKN Jawa Timur', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (253, 5, '005010500098235000KD', 'PENGADILAN NEGERI KEDIRI', 'general', 'Kediri', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Malang', 'Kantor Wilayah DJKN Jawa Timur', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (254, 5, '005010500098242000KD', 'PENGADILAN NEGERI NGANJUK', 'general', 'Nganjuk', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Surabaya', 'Kantor Wilayah DJKN Jawa Timur', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (255, 5, '005010500098260000KD', 'PENGADILAN NEGERI TRENGGALEK', 'general', 'Trenggalek', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Malang', 'Kantor Wilayah DJKN Jawa Timur', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (256, 5, '005010500098277000KD', 'PENGADILAN NEGERI BLITAR 01', 'general', 'Blitar', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Malang', 'Kantor Wilayah DJKN Jawa Timur', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (257, 5, '005010500098281000KD', 'PENGADILAN NEGERI MALANG', 'general', 'Malang', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Malang', 'Kantor Wilayah DJKN Jawa Timur', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (258, 5, '005010500098298000KD', 'PENGADILAN NEGERI PASURUAN', 'general', 'Pasuruan', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Sidoarjo', 'Kantor Wilayah DJKN Jawa Timur', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (259, 5, '005010500098303000KD', 'PENGADILAN NEGERI PROBOLINGGO', 'general', 'Probolinggo', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jember', 'Kantor Wilayah DJKN Jawa Timur', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (260, 5, '005010500098310000KD', 'PENGADILAN NEGERI LUMAJANG', 'general', 'Lumajang', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Malang', 'Kantor Wilayah DJKN Jawa Timur', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (261, 5, '005010500098324000KD', 'PENGADILAN NEGERI BANGIL', 'general', 'Bangil', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Sidoarjo', 'Kantor Wilayah DJKN Jawa Timur', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (262, 5, '005010500098345000KD', 'PENGADILAN NEGERI MADIUN', 'general', 'Madiun', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Madiun', 'Kantor Wilayah DJKN Jawa Timur', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (263, 5, '005010500098352000KD', 'PENGADILAN NEGERI PONOROGO', 'general', 'Ponorogo', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Madiun', 'Kantor Wilayah DJKN Jawa Timur', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (264, 5, '005010500098366000KD', 'PENGADILAN NEGERI PACITAN', 'general', 'Pacitan', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Madiun', 'Kantor Wilayah DJKN Jawa Timur', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (265, 5, '005010500098370000KD', 'PENGADILAN NEGERI NGAWI', 'general', 'Ngawi', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Madiun', 'Kantor Wilayah DJKN Jawa Timur', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (266, 5, '005010500098387000KD', 'PENGADILAN NEGERI MAGETAN', 'general', 'Magetan', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Madiun', 'Kantor Wilayah DJKN Jawa Timur', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (267, 5, '005010500098391000KD', 'PENGADILAN NEGERI KELAS IB PAMEKASAN', 'general', 'Pamekasan', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pamekasan', 'Kantor Wilayah DJKN Jawa Timur', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (268, 5, '005010500098409000KD', 'PENGADILAN NEGERI SUMENEP', 'general', 'Sumenep', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pamekasan', 'Kantor Wilayah DJKN Jawa Timur', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (269, 5, '005010500098413000KD', 'PENGADILAN NEGERI BANGKALAN', 'general', 'Bangkalan', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pamekasan', 'Kantor Wilayah DJKN Jawa Timur', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (270, 5, '005010500098420000KD', 'PENGADILAN NEGERI SAMPANG', 'general', 'Sampang', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pamekasan', 'Kantor Wilayah DJKN Jawa Timur', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (271, 5, '005010500308170000KD', 'PENGADILAN TINGGI AGAMA SURABAYA', 'tingkatbanding', 'Surabaya', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Surabaya', 'Kantor Wilayah DJKN Jawa Timur', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (272, 5, '005010500400580000KD', 'PENGADILAN NEGERI KAB. KEDIRI', 'general', 'Kab. Kediri', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Malang', 'Kantor Wilayah DJKN Jawa Timur', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (273, 5, '005010500400596000KD', 'PENGADILAN NEGERI KAB. MADIUN', 'general', 'Kab. Madiun', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Madiun', 'Kantor Wilayah DJKN Jawa Timur', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (274, 5, '005010500401240000KD', 'PENGADILAN AGAMA SURABAYA', 'general', 'Surabaya', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Surabaya', 'Kantor Wilayah DJKN Jawa Timur', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (275, 5, '005010500401256000KD', 'PENGADILAN AGAMA MOJOKERTO', 'general', 'Mojokerto', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Sidoarjo', 'Kantor Wilayah DJKN Jawa Timur', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (276, 5, '005010500401262000KD', 'PENGADILAN AGAMA SIDOARJO', 'general', 'Sidoarjo', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Sidoarjo', 'Kantor Wilayah DJKN Jawa Timur', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (277, 5, '005010500401271000KD', 'PA JOMBANG', 'general', 'Jombang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Malang', 'Kantor Wilayah DJKN Jawa Timur', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (278, 5, '005010500401287000KD', 'PA BAWEAN 01', 'general', 'Bawean', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Surabaya', 'Kantor Wilayah DJKN Jawa Timur', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (279, 5, '005010500401293000KD', 'PA GRESIK', 'general', 'Gresik', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Surabaya', 'Kantor Wilayah DJKN Jawa Timur', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (280, 5, '005010500401307000KD', 'Pengadilan Agama Bojonegoro', 'general', 'Bojonegoro', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Surabaya', 'Kantor Wilayah DJKN Jawa Timur', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (281, 5, '005010500401322000KD', 'PA LAMONGAN', 'general', 'Lamongan', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Surabaya', 'Kantor Wilayah DJKN Jawa Timur', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (282, 5, '005010500401338000KD', 'PENGADILAN AGAMA JEMBER', 'general', 'Jember', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jember', 'Kantor Wilayah DJKN Jawa Timur', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (283, 5, '005010500401344000KD', 'PENGADILAN AGAMA BONDOWOSO', 'general', 'Bondowoso', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jember', 'Kantor Wilayah DJKN Jawa Timur', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (284, 5, '005010500401350000KD', 'PENGADILAN AGAMA SITUBONDO', 'general', 'Situbondo', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jember', 'Kantor Wilayah DJKN Jawa Timur', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (285, 5, '005010500401375000KD', 'PENGADILAN AGAMA KAB. KEDIRI', 'general', 'Kabupaten Kediri', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Malang', 'Kantor Wilayah DJKN Jawa Timur', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (286, 5, '005010500401390000KD', 'PENGADILAN AGAMA TRENGGALEK', 'general', 'Trenggalek', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Malang', 'Kantor Wilayah DJKN Jawa Timur', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (287, 5, '005010500401401000KD', 'PENGADILAN AGAMA BLITAR', 'general', 'Blitar', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Malang', 'Kantor Wilayah DJKN Jawa Timur', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (288, 5, '005010500401410000KD', 'PENGADILAN AGAMA NGANJUK', 'general', 'Nganjuk', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Surabaya', 'Kantor Wilayah DJKN Jawa Timur', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (289, 5, '005010500401432000KD', 'PENGADILAN AGAMA PASURUAN', 'general', 'Pasuruan', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Sidoarjo', 'Kantor Wilayah DJKN Jawa Timur', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (290, 5, '005010500401441000KD', 'PA BANGIL', 'general', 'Bangil', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Sidoarjo', 'Kantor Wilayah DJKN Jawa Timur', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (291, 5, '005010500401457000KD', 'PENGADILAN AGAMA PROBOLINGGO', 'general', 'Probolinggo', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jember', 'Kantor Wilayah DJKN Jawa Timur', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (292, 5, '005010500401463000KD', 'PA KRAKSAAN', 'general', 'Kraksaan', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jember', 'Kantor Wilayah DJKN Jawa Timur', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (293, 5, '005010500401472000KD', 'PENGADILAN AGAMA LUMAJANG', 'general', 'Lumajang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Malang', 'Kantor Wilayah DJKN Jawa Timur', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (294, 5, '005010500401488000KD', 'PENGADILAN AGAMA KOTA MADIUN (01)', 'general', 'Madiun', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Madiun', 'Kantor Wilayah DJKN Jawa Timur', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (295, 5, '005010500401494000KD', 'PENGADILAN AGAMA MAGETAN', 'general', 'Magetan', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Madiun', 'Kantor Wilayah DJKN Jawa Timur', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (296, 5, '005010500401508000KD', 'PENGADILAN AGAMA NGAWI', 'general', 'Ngawi', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Madiun', 'Kantor Wilayah DJKN Jawa Timur', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (297, 5, '005010500401514000KD', 'PENGADILAN AGAMA PONOROGO (01)', 'general', 'Ponorogo', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Madiun', 'Kantor Wilayah DJKN Jawa Timur', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (298, 5, '005010500401520000KD', 'PENGADILAN AGAMA PACITAN (01)', 'general', 'Pacitan', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Madiun', 'Kantor Wilayah DJKN Jawa Timur', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (299, 5, '005010500401539000KD', 'PENGADILAN AGAMA PAMEKASAN', 'general', 'Pamekasan', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pamekasan', 'Kantor Wilayah DJKN Jawa Timur', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (300, 5, '005010500401545000KD', 'PENGADILAN AGAMA BANGKALAN', 'general', 'Bangkalan', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pamekasan', 'Kantor Wilayah DJKN Jawa Timur', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (301, 5, '005010500401551000KD', 'PENGADILAN AGAMA SAMPANG', 'general', 'Sampang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pamekasan', 'Kantor Wilayah DJKN Jawa Timur', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (302, 5, '005010500401560000KD', 'PENGADILAN AGAMA SUMENEP', 'general', 'Sumenep', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pamekasan', 'Kantor Wilayah DJKN Jawa Timur', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (303, 5, '005010500401576000KD', 'PENGADILAN AGAMA KANGEAN', 'general', 'Kangean', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pamekasan', 'Kantor Wilayah DJKN Jawa Timur', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (304, 5, '005010500403030000KD', 'PENGADILAN AGAMA KAB. MADIUN', 'general', 'Kabupaten Madiun', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Madiun', 'Kantor Wilayah DJKN Jawa Timur', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (305, 5, '005010500403046000KD', 'PENGADILAN AGAMA KEDIRI', 'general', 'Kediri', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Malang', 'Kantor Wilayah DJKN Jawa Timur', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (306, 5, '005010500450737000KD', 'PENGADILAN AGAMA TUBAN', 'general', 'Tuban', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Surabaya', 'Kantor Wilayah DJKN Jawa Timur', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (307, 5, '005010500526767000KD', 'KANTOR PTUN SBY 01', 'general', 'Surabaya', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', 'Kantor Pelayanan Kekayaan Negara dan Lelang Sidoarjo', 'Kantor Wilayah DJKN Jawa Timur', 'PT', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (308, 5, '005010500548940000KD', 'PENGADILAN TINGGI TUN SURABAYA', 'tingkatbanding', 'Surabaya', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', 'Kantor Pelayanan Kekayaan Negara dan Lelang Surabaya', 'Kantor Wilayah DJKN Jawa Timur', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (309, 5, '005010500604730000KD', 'PENGADILAN AGAMA KABUPATEN MALANG', 'general', 'Malang Kab. Malang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Malang', 'Kantor Wilayah DJKN Jawa Timur', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (310, 5, '005010500663300000KD', 'DILMILTI III SURABAYA', 'general', 'Surabaya', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', 'Kantor Pelayanan Kekayaan Negara dan Lelang Sidoarjo', 'Kantor Wilayah DJKN Jawa Timur', 'PM', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (311, 5, '005010500663314000KD', 'PENGADILAN MILITER III-12 SURABAYA', 'general', 'Surabaya', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', 'Kantor Pelayanan Kekayaan Negara dan Lelang Sidoarjo', 'Kantor Wilayah DJKN Jawa Timur', 'PM', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (312, 5, '005010500663321000KD', 'PENGADILAN MILITER III-13 MADIUN (01)', 'general', 'Madiun', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', 'Kantor Pelayanan Kekayaan Negara dan Lelang Madiun', 'Kantor Wilayah DJKN Jawa Timur', 'PM', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (313, 6, '005010600098434000KD', 'PENGADILAN TINGGI BANDA ACEH', 'tingkatbanding', 'Banda Aceh', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banda Aceh', 'Kantor Wilayah DJKN Aceh', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (314, 6, '005010600098455000KD', 'PENGADILAN NEGERI SABANG', 'general', 'Sabang', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banda Aceh', 'Kantor Wilayah DJKN Aceh', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (315, 6, '005010600098462000KD', 'PENGADILAN NEGERI SIGLI', 'general', 'Sigli', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banda Aceh', 'Kantor Wilayah DJKN Aceh', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (316, 6, '005010600098476000KD', 'PENGADILAN NEGERI BIREUEN', 'general', 'Beureun', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Lhokseumawe', 'Kantor Wilayah DJKN Aceh', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (317, 6, '005010600098480000KD', 'PENGADILAN NEGERI LHOKSUKON 01', 'general', 'Lhok Sukon', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Lhokseumawe', 'Kantor Wilayah DJKN Aceh', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (318, 6, '005010600098497000KD', 'PENGADILAN NEGERI LHOKSEUMAWE', 'general', 'Lhok Seumawe', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Lhokseumawe', 'Kantor Wilayah DJKN Aceh', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (319, 6, '005010600098502000KD', 'PENGADILAN NEGERI TAKENGON', 'general', 'Takengon', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Lhokseumawe', 'Kantor Wilayah DJKN Aceh', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (320, 6, '005010600098519000KD', 'PENGADILAN NEGERI LANGSA', 'general', 'Langsa', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Lhokseumawe', 'Kantor Wilayah DJKN Aceh', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (321, 6, '005010600098523000KD', 'PN IDI', 'general', 'Idi', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Lhokseumawe', 'Kantor Wilayah DJKN Aceh', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (322, 6, '005010600098530000KD', 'PENGADILAN NEGERI KUALASIMPANG', 'general', 'Kuala Simpang', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Lhokseumawe', 'Kantor Wilayah DJKN Aceh', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (323, 6, '005010600098544000KD', 'PENGADILAN NEGERI BLANGKEJEREN', 'general', 'Blangkajeren', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Lhokseumawe', 'Kantor Wilayah DJKN Aceh', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (324, 6, '005010600098551000KD', 'PENGADILAN NEGERI KUTACANE', 'general', 'Kutacane', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Lhokseumawe', 'Kantor Wilayah DJKN Aceh', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (325, 6, '005010600098565000KD', 'PENGADILAN NEGERI MEULABOH', 'general', 'Meulaboh', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banda Aceh', 'Kantor Wilayah DJKN Aceh', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (326, 6, '005010600098572000KD', 'PENGADILAN NEGERI CALANG', 'general', 'Calang', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banda Aceh', 'Kantor Wilayah DJKN Aceh', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (327, 6, '005010600098586000KD', 'PENGADILAN NEGERI SINABANG', 'general', 'Sinabang', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banda Aceh', 'Kantor Wilayah DJKN Aceh', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (328, 6, '005010600098608000KD', 'PENGADILAN NEGERI SINGKIL', 'general', 'Singkel', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banda Aceh', 'Kantor Wilayah DJKN Aceh', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (329, 6, '005010600400415000KD', 'PENGADILAN NEGERI JANTHO', 'general', 'Janthoi', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banda Aceh', 'Kantor Wilayah DJKN Aceh', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (330, 6, '005010600401582000KD', 'MAHKAMAH SYAR\'IYAH ACEH', 'general', 'Aceh', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banda Aceh', 'Kantor Wilayah DJKN Aceh', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (331, 6, '005010600401591000KD', 'MAHKAMAH SYAR\'IYAH BANDA ACEH', 'general', 'Banda Aceh', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banda Aceh', 'Kantor Wilayah DJKN Aceh', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (332, 6, '005010600401602000KD', 'MAHKAMAH SYAR\'IYAH SABANG', 'general', 'Sabang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banda Aceh', 'Kantor Wilayah DJKN Aceh', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (333, 6, '005010600401611000KD', 'MS SIGLI', 'general', 'Sigli', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banda Aceh', 'Kantor Wilayah DJKN Aceh', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (334, 6, '005010600401627000KD', 'MAHKAMAH SYAR\'IYAH MEUREUDU', 'general', 'Meureudu', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banda Aceh', 'Kantor Wilayah DJKN Aceh', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (335, 6, '005010600401633000KD', 'MAHKAMAH SYAR\'IYAH BIREUEN', 'general', 'Bireuen', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Lhokseumawe', 'Kantor Wilayah DJKN Aceh', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (336, 6, '005010600401642000KD', 'MAHKAMAH SYAR\'IYAH LHOKSUKON', 'general', 'Lhok Sukon', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Lhokseumawe', 'Kantor Wilayah DJKN Aceh', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (337, 6, '005010600401658000KD', 'MAHKAMAH SYAR\'IYAH TAKENGON', 'general', 'Takengon', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Lhokseumawe', 'Kantor Wilayah DJKN Aceh', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (338, 6, '005010600401664000KD', 'MAHKAMAH SYAR IYAH LHOKSEUMAWE', 'general', 'Lhok Seumawe', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Lhokseumawe', 'Kantor Wilayah DJKN Aceh', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (339, 6, '005010600401670000KD', 'MAHKAMAH SYAR IYAH IDI', 'general', 'Idi', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Lhokseumawe', 'Kantor Wilayah DJKN Aceh', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (340, 6, '005010600401689000KD', 'MAHKAMAH SYARIAH LANGSA', 'general', 'Langsa', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Lhokseumawe', 'Kantor Wilayah DJKN Aceh', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (341, 6, '005010600401695000KD', 'MAHKAMAH SYAR\'IYAH KUALASIMPANG', 'general', 'Kuala Simpang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Lhokseumawe', 'Kantor Wilayah DJKN Aceh', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (342, 6, '005010600401709000KD', 'MAHKAMAH SYAR\'IYAH BLANGKEJEREN', 'general', 'Blangkajeren', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Lhokseumawe', 'Kantor Wilayah DJKN Aceh', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (343, 6, '005010600401715000KD', 'MAHKAMAH SYAR\'IYAH KUTACANE', 'general', 'Kotacane', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Lhokseumawe', 'Kantor Wilayah DJKN Aceh', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (344, 6, '005010600401721000KD', 'MAHKAMAH SYAR\'IYAH MEULABOH', 'general', 'Meulaboh', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banda Aceh', 'Kantor Wilayah DJKN Aceh', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (345, 6, '005010600401730000KD', 'MAHKAMAH SYAR\'IYAH SINABANG', 'general', 'Sinabang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banda Aceh', 'Kantor Wilayah DJKN Aceh', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (346, 6, '005010600401746000KD', 'MAHKAMAH SYAR\'IYAH CALANG', 'general', 'Calang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banda Aceh', 'Kantor Wilayah DJKN Aceh', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (347, 6, '005010600401752000KD', 'MAHKAMAH SYAR\'IYAH SINGKIL', 'general', 'Singkil', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banda Aceh', 'Kantor Wilayah DJKN Aceh', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (348, 6, '005010600401761000KD', 'MAHKAMAH SYAR\'IYAH TAPAKTUAN', 'general', 'Tapak Tuan', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banda Aceh', 'Kantor Wilayah DJKN Aceh', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (349, 6, '005010600402607000KD', 'MAHKAMAH SYAR\'IYAH JANTHO', 'general', 'Jantho', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banda Aceh', 'Kantor Wilayah DJKN Aceh', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (350, 6, '005010600578818000KD', 'PENGADILAN TATA USAHA NEGARA BANDA ACEH', 'general', 'Banda Aceh', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banda Aceh', 'Kantor Wilayah DJKN Aceh', 'PT', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (351, 6, '005010600673062000KD', 'PENGADILAN NEGERI SIMPANG TIGA REDELONG', 'general', 'Simpang Tiga Redelong', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Lhokseumawe', 'Kantor Wilayah DJKN Aceh', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (352, 6, '005010600682228000KD', 'MAHKAMAH SYAR\'IYAH SIMPANG TIGA REDELONG', 'general', 'Mahkamah Syariyah Simpang Tiga Redelong', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Lhokseumawe', 'Kantor Wilayah DJKN Aceh', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (353, 7, '005010700098612000KD', 'PENGADILAN TINGGI MEDAN', 'tingkatbanding', 'Medan', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Medan', 'Kantor Wilayah DJKN Sumatera Utara', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (354, 7, '005010700098629000KD', 'PENGADILAN NEGERI MEDAN', 'general', 'Medan', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Medan', 'Kantor Wilayah DJKN Sumatera Utara', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (355, 7, '005010700098633000KD', 'PENGADILAN NEGERI BINJAI', 'general', 'Binjai', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Medan', 'Kantor Wilayah DJKN Sumatera Utara', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (356, 7, '005010700098640000KD', 'PENGADILAN NEGERI TANJUNGBALAI', 'general', 'Tanjung Balai Asahan', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kisaran', 'Kantor Wilayah DJKN Sumatera Utara', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (357, 7, '005010700098654000KD', 'PENGADILAN NEGERI SIDIKALANG', 'general', 'Sidikalang', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pematang Siantar', 'Kantor Wilayah DJKN Sumatera Utara', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (358, 7, '005010700098661000KD', 'PENGADILAN NEGERI KABANJAHE', 'general', 'Kabanjahe', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Medan', 'Kantor Wilayah DJKN Sumatera Utara', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (359, 7, '005010700098675000KD', 'PENGADILAN NEGERI RANTAUPRAPAT', 'general', 'Rantau Prapat', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kisaran', 'Kantor Wilayah DJKN Sumatera Utara', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (360, 7, '005010700098682000KD', 'PENGADILAN NEGERI TEBING TINGGI', 'tingkatbanding', 'Tebing Tinggi', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pematang Siantar', 'Kantor Wilayah DJKN Sumatera Utara', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (361, 7, '005010700098696000KD', 'PENGADILAN NEGERI GUNUNGSITOLI', 'general', 'Gunung Sitoli', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Padangsidimpuan', 'Kantor Wilayah DJKN Sumatera Utara', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (362, 7, '005010700098701000KD', 'PENGADILAN NEGERI PEMATANGSIANTAR', 'general', 'Pematang Siantar', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pematang Siantar', 'Kantor Wilayah DJKN Sumatera Utara', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (363, 7, '005010700098722000KD', 'PENGADILAN NEGERI PADANGSIDIMPUAN', 'general', 'Padang Sidempuan', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Padangsidimpuan', 'Kantor Wilayah DJKN Sumatera Utara', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (364, 7, '005010700098739000KD', 'PENGADILAN NEGERI SIBOLGA', 'general', 'Sibolga', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Padangsidimpuan', 'Kantor Wilayah DJKN Sumatera Utara', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (365, 7, '005010700108025000KD', 'PENGADILAN NEGERI STABAT', 'general', 'Stabat', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Medan', 'Kantor Wilayah DJKN Sumatera Utara', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (366, 7, '005010700400370000KD', 'PENGADILAN NEGERI SIMALUNGUN', 'general', 'Simalungun', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pematang Siantar', 'Kantor Wilayah DJKN Sumatera Utara', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (367, 7, '005010700400395000KD', 'PENGADILAN NEGERI LUBUK PAKAM KELAS I.A', 'general', 'Lubuk Pakam', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Medan', 'Kantor Wilayah DJKN Sumatera Utara', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (368, 7, '005010700401777000KD', 'PENGADILAN TINGGI AGAMA MEDAN', 'tingkatbanding', 'Medan', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Medan', 'Kantor Wilayah DJKN Sumatera Utara', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (369, 7, '005010700401783000KD', 'PENGADILAN AGAMA BINJAI', 'general', 'Binjai', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Medan', 'Kantor Wilayah DJKN Sumatera Utara', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (370, 7, '005010700401792000KD', 'PENGADILAN AGAMA KABANJAHE', 'general', 'Kabanjahe', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Medan', 'Kantor Wilayah DJKN Sumatera Utara', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (371, 7, '005010700401803000KD', 'PENGADILAN AGAMA MEDAN', 'general', 'Medan', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Medan', 'Kantor Wilayah DJKN Sumatera Utara', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (372, 7, '005010700401812000KD', 'PENGADILAN AGAMA RANTAUPRAPAT', 'general', 'Rantau Prapat', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kisaran', 'Kantor Wilayah DJKN Sumatera Utara', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (373, 7, '005010700401828000KD', 'PENGADILAN AGAMA TANJUNGBALAI', 'general', 'Tanjung Balai', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kisaran', 'Kantor Wilayah DJKN Sumatera Utara', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (374, 7, '005010700401834000KD', 'PENGADILAN AGAMA TEBING TINGGI', 'tingkatbanding', 'Tebing Tinggi', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pematang Siantar', 'Kantor Wilayah DJKN Sumatera Utara', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (375, 7, '005010700401840000KD', 'PENGADILAN AGAMA SIDIKALANG', 'general', 'Sidikalang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pematang Siantar', 'Kantor Wilayah DJKN Sumatera Utara', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (376, 7, '005010700401859000KD', 'PENGADILAN AGAMA PEMATANGSIANTAR', 'general', 'Pematang Siantar', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pematang Siantar', 'Kantor Wilayah DJKN Sumatera Utara', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (377, 7, '005010700401865000KD', 'PENGADILAN AGAMA BALIGE', 'general', 'Balige', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pematang Siantar', 'Kantor Wilayah DJKN Sumatera Utara', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (378, 7, '005010700401871000KD', 'PENGADILAN AGAMA SIBOLGA', 'general', 'Sibolga', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Padangsidimpuan', 'Kantor Wilayah DJKN Sumatera Utara', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (379, 7, '005010700401880000KD', 'PENGADILAN AGAMA PADANGSIDIMPUAN', 'general', 'Padang Sidempuan', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Padangsidimpuan', 'Kantor Wilayah DJKN Sumatera Utara', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (380, 7, '005010700401896000KD', 'PENGADILAN AGAMA GUNUNGSITOLI', 'general', 'Gunung Sitoli', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Padangsidimpuan', 'Kantor Wilayah DJKN Sumatera Utara', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (381, 7, '005010700403061000KD', 'PA KISARAN', 'general', 'Kisaran', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kisaran', 'Kantor Wilayah DJKN Sumatera Utara', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (382, 7, '005010700403077000KD', 'PENGADILAN AGAMA LUBUK PAKAM', 'general', 'Lubuk Pakam', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Medan', 'Kantor Wilayah DJKN Sumatera Utara', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (383, 7, '005010700403083000KD', 'PENGADILAN AGAMA SIMALUNGUN', 'general', 'Simalungun', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pematang Siantar', 'Kantor Wilayah DJKN Sumatera Utara', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (384, 7, '005010700526725000KD', 'PENGADILAN TINGGI TATA USAHA NEGARA MEDAN', 'tingkatbanding', 'Medan', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', 'Kantor Pelayanan Kekayaan Negara dan Lelang Medan', 'Kantor Wilayah DJKN Sumatera Utara', 'PT', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (385, 7, '005010700526746000KD', 'PENGADILAN TATA USAHA NEGARA MEDAN', 'general', 'Medan', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', 'Kantor Pelayanan Kekayaan Negara dan Lelang Medan', 'Kantor Wilayah DJKN Sumatera Utara', 'PT', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (386, 7, '005010700547682000KD', 'PENGADILAN AGAMA STABAT', 'general', 'Stabat', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Medan', 'Kantor Wilayah DJKN Sumatera Utara', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (387, 7, '005010700604744000KD', 'PENGADILAN AGAMA PANDAN', 'general', 'Pandan', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Padangsidimpuan', 'Kantor Wilayah DJKN Sumatera Utara', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (388, 7, '005010700631978000KD', 'PENGADILAN AGAMA TARUTUNG', 'general', 'Tarutung', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Padangsidimpuan', 'Kantor Wilayah DJKN Sumatera Utara', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (389, 7, '005010700631982000KD', 'PENGADILAN AGAMA PANYABUNGAN', 'general', 'Panyabungan', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Padangsidimpuan', 'Kantor Wilayah DJKN Sumatera Utara', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (390, 7, '005010700663178000KD', 'PENGADILAN MILITER TINGGI I MEDAN', 'tingkatbanding', 'Medan', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', 'Kantor Pelayanan Kekayaan Negara dan Lelang Medan', 'Kantor Wilayah DJKN Sumatera Utara', 'PM', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (391, 7, '005010700672910000KD', 'PENGADILAN NEGERI BALIGE', 'general', 'Balige', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pematang Siantar', 'Kantor Wilayah DJKN Sumatera Utara', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (392, 7, '005010700682232000KD', 'PENGADILAN AGAMA KOTA PADANGSIDIMPUAN', 'general', 'Kota Padang Sidempuan', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Padangsidimpuan', 'Kantor Wilayah DJKN Sumatera Utara', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (393, 8, '005010800098743000KD', 'PENGADILAN TINGGI PADANG', 'tingkatbanding', 'Padang', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Padang', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (394, 8, '005010800098750000KD', 'PENGADILAN NEGERI KLAS I A PADANG', 'general', 'Padang', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Padang', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (395, 8, '005010800098764000KD', 'PENGADILAN NEGERI SAWAHLUNTO', 'general', 'Sawahlunto', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Padang', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (396, 8, '005010800098771000KD', 'PENGADILAN NEGERI BATUSANGKAR', 'general', 'Batusangkar', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bukittinggi', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (397, 8, '005010800098785000KD', 'PENGADILAN NEGERI SOLOK', 'general', 'Solok', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Padang', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (398, 8, '005010800098792000KD', 'PENGADILAN NEGERI PARIAMAN', 'general', 'Pariaman', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Padang', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (399, 8, '005010800098807000KD', 'PENGADILAN NEGERI PAINAN', 'general', 'Painan', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Padang', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (400, 8, '005010800098811000KD', 'PENGADILAN NEGERI BUKITTINGGI', 'tingkatbanding', 'Bukittinggi', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bukittinggi', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (401, 8, '005010800098828000KD', 'PENGADILAN NEGERI LUBUK SIKAPING', 'general', 'Lubuk Sikaping', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bukittinggi', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (402, 8, '005010800098832000KD', 'PENGADILAN NEGERI PAYAKUMBUH', 'general', 'Payakumbuh', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bukittinggi', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (403, 8, '005010800400188000KD', 'PENGADILAN NEGERI PADANG PANJANG (01)', 'general', 'Padang Panjang', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bukittinggi', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (404, 8, '005010800400333000KD', 'PENGADILAN NEGERI LUBUK BASUNG', 'general', 'Lubuk Basung', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bukittinggi', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (405, 8, '005010800400421000KD', 'PENGADILAN NEGERI TANJUNG PATI', 'general', 'Tanjung Pati', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bukittinggi', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (406, 8, '005010800400461000KD', 'PENGADILAN NEGERI MUARO (BUA)', 'general', 'Muaro', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Padang', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (407, 8, '005010800401900000KD', 'PENGADILAN TINGGI AGAMA PADANG', 'tingkatbanding', 'Padang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Padang', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (408, 8, '005010800401922000KD', 'PENGADILAN AGAMA SOLOK', 'general', 'Solok', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Padang', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (409, 8, '005010800401931000KD', 'PENGADILAN AGAMA SAWAHLUNTO', 'general', 'Sawahlunto', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Padang', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (410, 8, '005010800401953000KD', 'PENGADILAN AGAMA PADANG', 'general', 'Padang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Padang', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (411, 8, '005010800401962000KD', 'PENGADILAN AGAMA PADANG PANJANG', 'general', 'Padang Panjang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bukittinggi', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (412, 8, '005010800401978000KD', 'PENGADILAN AGAMA SIJUNJUNG', 'general', 'Sijunjung', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Padang', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (413, 8, '005010800401984000KD', 'PENGADILAN AGAMA KOTO BARU', 'general', 'Koto Baru', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Padang', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (414, 8, '005010800401990000KD', 'PENGADILAN AGAMA MUARALABUH', 'general', 'Muara Labuh', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Padang', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (415, 8, '005010800402004000KD', 'PENGADILAN AGAMA PAINAN', 'general', 'Painan', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Padang', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (416, 8, '005010800402010000KD', 'PENGADILAN AGAMA BUKITTINGGI KELAS IB', 'tingkatbanding', 'Bukittinggi', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bukittinggi', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (417, 8, '005010800402029000KD', 'PENGADILAN AGAMA LUBUK SIKAPING', 'general', 'Lubuk Sikaping', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bukittinggi', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (418, 8, '005010800402035000KD', 'PENGADILAN AGAMA TALU', 'general', 'Talu', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bukittinggi', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (419, 8, '005010800402041000KD', 'PENGADILAN AGAMA MANINJAU (01)', 'general', 'Maninjau', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bukittinggi', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (420, 8, '005010800402066000KD', 'PENGADILAN AGAMA TANJUNG PATI', 'general', 'Tanjung Pati', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bukittinggi', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (421, 8, '005010800402613000KD', 'PENGADILAN AGAMA LUBUK BASUNG', 'general', 'Lubuk Basung', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bukittinggi', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (422, 8, '005010800477352000KD', 'PENGADILAN NEGERI PASAMAN BARAT ( BUA )', 'general', 'Pasaman Barat', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bukittinggi', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (423, 8, '005010800531844000KD', 'PENGADILAN TATA USAHA NEGARA PADANG', 'general', 'Padang', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', 'Kantor Pelayanan Kekayaan Negara dan Lelang Padang', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PT', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (424, 8, '005010800663204000KD', 'PENGADILAN MILITER I-03 PADANG', 'general', 'Padang', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', 'Kantor Pelayanan Kekayaan Negara dan Lelang Padang', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PM', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (425, 9, '005010900098849000KD', 'PENGADILAN NEGERI PEKANBARU', 'general', 'Pekanbaru', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pekanbaru', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (426, 9, '005010900098853000KD', 'PENGADILAN NEGERI BENGKALIS', 'general', 'Bengkalis', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Dumai', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (427, 9, '005010900098860000KD', 'PENGADILAN NEGERI RENGAT', 'general', 'Rengat/Indragiri', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pekanbaru', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (428, 9, '005010900098874000KD', 'PENGADILAN NEGERI TEMBILAHAN', 'general', 'Tembilahan', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pekanbaru', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (429, 9, '005010900400141000KD', 'PENGADILAN NEGERI BANGKINANG', 'general', 'Bangkinang', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pekanbaru', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (430, 9, '005010900400327000KD', 'PENGADILAN NEGERI DUMAI', 'general', 'Dumai', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Dumai', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (431, 9, '005010900400492000KD', 'PENGADILAN TINGGI PEKANBARU', 'tingkatbanding', 'Pekanbaru', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pekanbaru', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (432, 9, '005010900402072000KD', 'PENGADILAN AGAMA PEKANBARU', 'general', 'Pekanbaru', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pekanbaru', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (433, 9, '005010900402081000KD', 'PENGADILAN AGAMA RENGAT', 'general', 'Rengat', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pekanbaru', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (434, 9, '005010900402097000KD', 'PENGADILAN AGAMA TEMBILAHAN', 'general', 'Tembilahan', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pekanbaru', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (435, 9, '005010900402101000KD', 'PENGADILAN AGAMA BANGKINANG', 'general', 'Bangkinang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pekanbaru', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (436, 9, '005010900402117000KD', 'PENGADILAN AGAMA BENGKALIS', 'general', 'Bengkalis', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Dumai', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (437, 9, '005010900402123000KD', 'PENGADILAN AGAMA PASIR PENGARAIAN', 'general', 'Pasir Pangarayan', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pekanbaru', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (438, 9, '005010900402132000KD', 'PENGADILAN AGAMA SELATPANJANG', 'general', 'Selat Panjang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Dumai', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (439, 9, '005010900402970000KD', 'PENGADILAN TINGGI AGAMA PEKANBARU', 'tingkatbanding', 'Pekanbaru', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pekanbaru', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (440, 9, '005010900477255000KD', 'PENGADILAN NEGERI PELALAWAN', 'general', 'Pelalawan', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pekanbaru', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (441, 9, '005010900477343000KD', 'PENGADILAN NEGERI SIAK SRI INDRAPURA', 'general', 'Siak Sri Indrapura', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Dumai', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (442, 9, '005010900578822000KD', 'PENGADILAN TATA USAHA NEGARA PEKANBARU', 'general', 'Pekan Baru', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pekanbaru', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PT', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (443, 9, '005010900632001000KD', 'PENGADILAN AGAMA UJUNG TANJUNG', 'general', 'Ujung Tanjung', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Dumai', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (444, 9, '005010900662990000KD', 'PENGADILAN NEGERI PASIR PENGARAIAN', 'general', 'Pasir Pangaraian', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pekanbaru', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (445, 10, '005011000098895000KD', 'PENGADILAN NEGERI JAMBI', 'general', 'Jambi', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jambi', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (446, 10, '005011000098900000KD', 'PENGADILAN NEGERI MUARA BUNGO 01', 'general', 'Muara Bungo', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jambi', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (447, 10, '005011000098921000KD', 'PENGADILAN NEGERI SUNGAI PENUH', 'general', 'Sungai Penuh', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jambi', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (448, 10, '005011000400311000KD', 'PENGADILAN NEGERI BANGKO', 'general', 'Bangko', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jambi', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (449, 10, '005011000400503000KD', 'PENGADILAN TINGGI JAMBI', 'tingkatbanding', 'Jambi', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jambi', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (450, 10, '005011000402185000KD', 'PENGADILAN AGAMA JAMBI', 'general', 'Jambi', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jambi', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (451, 10, '005011000402205000KD', 'PENGADILAN AGAMA KUALA TUNGKAL', 'general', 'Kuala Tungkal', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jambi', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (452, 10, '005011000402211000KD', 'PENGADILAN AGAMA BANGKO', 'general', 'Bangko', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jambi', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (453, 10, '005011000402220000KD', 'PENGADILAN AGAMA SUNGAI PENUH', 'general', 'Sungai Penuh', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jambi', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (454, 10, '005011000477368000KD', 'PENGADILAN NEGERI TEBO', 'general', 'Tebo', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jambi', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (455, 10, '005011000477374000KD', 'PENGADILAN NEGERI SAROLANGUN', 'general', 'Sarolangun', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jambi', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (456, 10, '005011000477400000KD', 'PENGADILAN NEGERI TANJUNG JABUNG TIMUR', 'general', 'Tanjung Jabung Timur', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jambi', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (457, 10, '005011000547661000KD', 'PENGADILAN TINGGI AGAMA JAMBI', 'tingkatbanding', 'Jambi', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jambi', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (458, 10, '005011000578839000KD', 'PENGADILAN TATA USAHA NEGARA JAMBI', 'general', 'Jambi', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jambi', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PT', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (459, 10, '005011000632018000KD', 'PENGADILAN AGAMA SAROLANGUN', 'general', 'Sarolangun', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jambi', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (460, 10, '005011000632022000KD', 'PENGADILAN AGAMA MUARA SABAK', 'general', 'Muara Sabak', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jambi', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (461, 10, '005011000652020000KD', 'PENGADILAN AGAMA MUARA TEBO', 'general', 'Muara Tebo', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jambi', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (462, 10, '005011000652034000KD', 'PENGADILAN AGAMA SENGETI', 'general', 'Sengeti', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jambi', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (463, 10, '005011000663012000KD', 'PENGADILAN NEGERI SENGETI', 'general', 'Sengeti', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jambi', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (464, 11, '005011100098938000KD', 'PENGADILAN TINGGI PALEMBANG', 'tingkatbanding', 'Palembang', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Palembang', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (465, 11, '005011100098942000KD', 'PENGADILAN NEGERI PALEMBANG', 'general', 'Palembang', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Palembang', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (466, 11, '005011100098959000KD', 'PENGADILAN NEGERI KAYU AGUNG', 'general', 'Kayuagung', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Palembang', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (467, 11, '005011100098970000KD', 'PENGADILAN NEGERI LUBUKLINGGAU', 'general', 'Lubuk Lingau', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Lahat', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (468, 11, '005011100098984000KD', 'PENGADILAN NEGERI LAHAT (01)', 'general', 'Lahat', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Lahat', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (469, 11, '005011100098991000KD', 'PENGADILAN NEGERI MUARA ENIM', 'general', 'Muara Enim', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Lahat', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (470, 11, '005011100402236000KD', 'PENGADILAN TINGGI AGAMA PALEMBANG', 'tingkatbanding', 'Palembang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Palembang', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (471, 11, '005011100402251000KD', 'PENGADILAN AGAMA LAHAT', 'general', 'Lahat', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Lahat', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (472, 11, '005011100402267000KD', 'PENGADILAN AGAMA BATURAJA', 'general', 'Baturaja', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Palembang', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (473, 11, '005011100402273000KD', 'PENGADILAN AGAMA KAYUAGUNG', 'general', 'Kayu Agung', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Palembang', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (474, 11, '005011100402282000KD', 'PENGADILAN AGAMA MUARA ENIM (01)', 'general', 'Muara Enim', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Lahat', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (475, 11, '005011100402298000KD', 'PENGADILAN AGAMA LUBUKLINGGAU', 'general', 'Lubuk Linggau', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Lahat', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (476, 11, '005011100402638000KD', 'PENGADILAN AGAMA SEKAYU', 'general', 'Sekayu', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Palembang', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (477, 11, '005011100526750000KD', 'PENGADILAN TATA USAHA NEGARA PALEMBANG', 'general', 'Palembang', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', 'Kantor Pelayanan Kekayaan Negara dan Lelang Palembang', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PT', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (478, 11, '005011100663211000KD', 'PENGADILAN MILITER I-04 PALEMBANG', 'general', 'Palembang', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', 'Kantor Pelayanan Kekayaan Negara dan Lelang Palembang', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PM', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (479, 11, '005011100672952000KD', 'PENGADILAN NEGERI PRABUMULIH', 'general', 'Prabumulih', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Palembang', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (480, 11, '005011100672969000KD', 'PENGADILAN NEGERI PAGAR ALAM', 'general', 'Pagar Alam', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Lahat', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (481, 12, '005011200099031000KD', 'PENGADILAN NEGERI TANJUNG KARANG KELAS 1A', 'general', 'Tanjung Karang', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bandar Lampung', 'Kantor Wilayah DJKN Lampung Dan Bengkulu', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (482, 12, '005011200099052000KD', 'PENGADILAN NEGERI KOTABUMI', 'general', 'Kotabumi', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Metro', 'Kantor Wilayah DJKN Lampung Dan Bengkulu', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (483, 12, '005011200400364000KD', 'PT TANJUNG KARANG', 'general', 'Tanjung Karang', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bandar Lampung', 'Kantor Wilayah DJKN Lampung Dan Bengkulu', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (484, 12, '005011200400452000KD', 'PN KALIANDA', 'general', 'Kalianda', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bandar Lampung', 'Kantor Wilayah DJKN Lampung Dan Bengkulu', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (485, 12, '005011200402324000KD', 'PA TANJUNG KARANG', 'general', 'Tanjung Karang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bandar Lampung', 'Kantor Wilayah DJKN Lampung Dan Bengkulu', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (486, 12, '005011200402330000KD', 'PA KRUI', 'general', 'Krui', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bandar Lampung', 'Kantor Wilayah DJKN Lampung Dan Bengkulu', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (487, 12, '005011200402349000KD', 'PA KOTABUMI', 'general', 'Kotabumi', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Metro', 'Kantor Wilayah DJKN Lampung Dan Bengkulu', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (488, 12, '005011200402355000KD', 'PENGADILAN AGAMA METRO', 'general', 'Metro', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Metro', 'Kantor Wilayah DJKN Lampung Dan Bengkulu', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (489, 12, '005011200402644000KD', 'PA KALIANDA', 'general', 'Kalianda', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bandar Lampung', 'Kantor Wilayah DJKN Lampung Dan Bengkulu', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (490, 12, '005011200477306000KD', 'PENGADILAN NEGERI KOTA AGUNG', 'general', 'Kota Agung', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bandar Lampung', 'Kantor Wilayah DJKN Lampung Dan Bengkulu', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (491, 12, '005011200559840000KD', 'Pengadilan Tata Usaha Negara Bandar Lampung', 'general', 'Bandar Lampung', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bandar Lampung', 'Kantor Wilayah DJKN Lampung Dan Bengkulu', 'PT', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (492, 12, '005011200614684000KD', 'PA TULANG BAWANG', 'general', 'Tulang Bawang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Metro', 'Kantor Wilayah DJKN Lampung Dan Bengkulu', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (493, 12, '005011200614691000KD', 'PA TANGGAMUS', 'general', 'Tanggamus', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bandar Lampung', 'Kantor Wilayah DJKN Lampung Dan Bengkulu', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (494, 12, '005011200614883000KD', 'PN LIWA', 'general', 'Liwa Kabupaten Lampung Barat', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bandar Lampung', 'Kantor Wilayah DJKN Lampung Dan Bengkulu', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (495, 12, '005011200652041000KD', 'PA GUNUNG SUGIH 01', 'general', 'Gunung Sugih', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Metro', 'Kantor Wilayah DJKN Lampung Dan Bengkulu', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (496, 12, '005011200663026000KD', 'PENGADILAN NEGERI MENGGALA', 'general', 'Menggala', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Metro', 'Kantor Wilayah DJKN Lampung Dan Bengkulu', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (497, 12, '005011200663030000KD', 'PN GUNUNG SUGIH', 'general', 'Gunung Sugih', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Metro', 'Kantor Wilayah DJKN Lampung Dan Bengkulu', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (498, 12, '005011200663047000KD', 'PENGADILAN NEGERI SUKADANA', 'general', 'Sukadana', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Metro', 'Kantor Wilayah DJKN Lampung Dan Bengkulu', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (499, 12, '005011200663051000KD', 'PENGADILAN NEGERI BLAMBANGAN UMPU', 'general', 'Blambangan Umpu', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Metro', 'Kantor Wilayah DJKN Lampung Dan Bengkulu', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (500, 13, '005011300099070000KD', 'PENGADILAN NEGERI SINGKAWANG (01)', 'general', 'Singkawang', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Singkawang', 'Kantor Wilayah DJKN Kalimantan Barat', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (501, 13, '005011300099087000KD', 'PENGADILAN NEGERI SINTANG', 'general', 'Sintang', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pontianak', 'Kantor Wilayah DJKN Kalimantan Barat', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (502, 13, '005011300099091000KD', 'PENGADILAN NEGERI KETAPANG ', 'general', 'Ketapang', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pontianak', 'Kantor Wilayah DJKN Kalimantan Barat', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (503, 13, '005011300099109000KD', 'PENGADILAN NEGERI MEMPAWAH', 'general', 'Mempawah', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pontianak', 'Kantor Wilayah DJKN Kalimantan Barat', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (504, 13, '005011300099113000KD', 'PENGADILAN NEGERI SANGGAU', 'general', 'Sanggau', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pontianak', 'Kantor Wilayah DJKN Kalimantan Barat', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (505, 13, '005011300400194000KD', 'PENGADILAN NEGERI PUTUSSIBAU', 'general', 'Putussibau', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pontianak', 'Kantor Wilayah DJKN Kalimantan Barat', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (506, 13, '005011300400251000KD', 'PENGADILAN TINGGI PONTIANAK', 'tingkatbanding', 'Pontianak', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pontianak', 'Kantor Wilayah DJKN Kalimantan Barat', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (507, 13, '005011300402361000KD', 'PENGADILAN AGAMA PONTIANAK', 'general', 'Pontianak', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pontianak', 'Kantor Wilayah DJKN Kalimantan Barat', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (508, 13, '005011300402370000KD', 'PENGADILAN AGAMA SAMBAS', 'general', 'Sambas', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Singkawang', 'Kantor Wilayah DJKN Kalimantan Barat', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (509, 13, '005011300402386000KD', 'PENGADILAN AGAMA KETAPANG', 'general', 'Ketapang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pontianak', 'Kantor Wilayah DJKN Kalimantan Barat', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (510, 13, '005011300402392000KD', 'PENGADILAN AGAMA SANGGAU', 'general', 'Sanggau', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pontianak', 'Kantor Wilayah DJKN Kalimantan Barat', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (511, 13, '005011300402406000KD', 'PENGADILAN AGAMA SINTANG', 'general', 'Sintang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pontianak', 'Kantor Wilayah DJKN Kalimantan Barat', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (512, 13, '005011300402412000KD', 'PENGADILAN AGAMA PUTUSSIBAU', 'general', 'Putussibau', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pontianak', 'Kantor Wilayah DJKN Kalimantan Barat', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (513, 13, '005011300402650000KD', 'PTA. PONTIANAK', 'general', 'Pontianak', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pontianak', 'Kantor Wilayah DJKN Kalimantan Barat', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (514, 13, '005011300402669000KD', 'PENGADILAN AGAMA MEMPAWAH', 'general', 'Mempawah', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pontianak', 'Kantor Wilayah DJKN Kalimantan Barat', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (515, 13, '005011300531851000KD', 'PTUN PONTIANAK', 'general', 'Pontianak', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pontianak', 'Kantor Wilayah DJKN Kalimantan Barat', 'PT', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (516, 13, '005011300632039000KD', 'PENGADILAN AGAMA BENGKAYANG', 'general', 'Bengkayang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Singkawang', 'Kantor Wilayah DJKN Kalimantan Barat', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (517, 13, '005011300663225000KD', 'PENGADILAN MILITER I-05 PONTIANAK (01)', 'general', 'Pontianak', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pontianak', 'Kantor Wilayah DJKN Kalimantan Barat', 'PM', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (518, 13, '005011300670231000KD', 'PENGADILAN NEGERI BENGKAYANG (01)', 'general', 'Bengkayang', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Singkawang', 'Kantor Wilayah DJKN Kalimantan Barat', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (519, 13, '005011300681450000KD', 'PENGADILAN NEGERI NGABANG', 'general', 'Ngabang', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pontianak', 'Kantor Wilayah DJKN Kalimantan Barat', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (520, 14, '005011400099120000KD', 'PENGADILAN NEGERI PALANGKA RAYA', 'general', 'Palangkaraya', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Palangkaraya', 'Kantor Wilayah DJKN Kalimantan Selatan Dan Tengah', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (521, 14, '005011400099141000KD', 'PENGADILAN NEGERI MUARA TEWEH', 'general', 'Muara Tewe', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Palangkaraya', 'Kantor Wilayah DJKN Kalimantan Selatan Dan Tengah', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (522, 14, '005011400099155000KD', 'PENGADILAN NEGERI KUALA KAPUAS', 'general', 'Kuala Kapuas', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Palangkaraya', 'Kantor Wilayah DJKN Kalimantan Selatan Dan Tengah', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (523, 14, '005011400099162000KD', 'PENGADILAN NEGERI BUNTOK', 'general', 'Buntok', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Palangkaraya', 'Kantor Wilayah DJKN Kalimantan Selatan Dan Tengah', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (524, 14, '005011400099176000KD', 'PENGADILAN NEGERI SAMPIT', 'general', 'Sampit', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pangkalan Bun', 'Kantor Wilayah DJKN Kalimantan Selatan Dan Tengah', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (525, 14, '005011400400358000KD', 'PENGADILAN TINGGI PALANGKA RAYA', 'tingkatbanding', 'Palangkaraya', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Palangkaraya', 'Kantor Wilayah DJKN Kalimantan Selatan Dan Tengah', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (526, 14, '005011400402421000KD', 'PENGADILAN AGAMA PALANGKA RAYA', 'general', 'Palangkaraya', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Palangkaraya', 'Kantor Wilayah DJKN Kalimantan Selatan Dan Tengah', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (527, 14, '005011400402437000KD', 'PENGADILAN AGAMA PANGKALAN BUN', 'general', 'Pangkalan Bun', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pangkalan Bun', 'Kantor Wilayah DJKN Kalimantan Selatan Dan Tengah', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (528, 14, '005011400402443000KD', 'PENGADILAN AGAMA MUARA TEWEH', 'general', 'Muara Tewe', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Palangkaraya', 'Kantor Wilayah DJKN Kalimantan Selatan Dan Tengah', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (529, 14, '005011400402452000KD', 'Pengadilan Agama Buntok', 'general', 'Buntok', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Palangkaraya', 'Kantor Wilayah DJKN Kalimantan Selatan Dan Tengah', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (530, 14, '005011400402468000KD', 'PENGADILAN AGAMA KUALA KAPUAS', 'general', 'Kuala Kapuas', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Palangkaraya', 'Kantor Wilayah DJKN Kalimantan Selatan Dan Tengah', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (531, 14, '005011400402474000KD', 'PENGADILAN AGAMA SAMPIT', 'general', 'Sampit', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pangkalan Bun', 'Kantor Wilayah DJKN Kalimantan Selatan Dan Tengah', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (532, 14, '005011400402989000KD', 'PENGADILAN TINGGI AGAMA PALANGKA RAYA', 'tingkatbanding', 'Palangkaraya', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Palangkaraya', 'Kantor Wilayah DJKN Kalimantan Selatan Dan Tengah', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (533, 14, '005011400578843000KD', 'PENGADILAN TATA USAHA NEGARA PALANGKA RAYA01', 'general', 'Palangkaraya', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', 'Kantor Pelayanan Kekayaan Negara dan Lelang Palangkaraya', 'Kantor Wilayah DJKN Kalimantan Selatan Dan Tengah', 'PT', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (534, 14, '005011400670191000KD', 'Pengadilan Negeri Tamiang Layang', 'general', 'Tamiang Layang', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Palangkaraya', 'Kantor Wilayah DJKN Kalimantan Selatan Dan Tengah', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (535, 15, '005011500099180000KD', 'PENGADILAN TINGGI BANJARMASIN', 'tingkatbanding', 'Banjarmasin', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banjarmasin', 'Kantor Wilayah DJKN Kalimantan Selatan Dan Tengah', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (536, 15, '005011500099197000KD', 'PENGADILAN NEGERI BANJARMASIN', 'general', 'Banjarmasin', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banjarmasin', 'Kantor Wilayah DJKN Kalimantan Selatan Dan Tengah', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (537, 15, '005011500099202000KD', 'PENGADILAN NEGERI KANDANGAN', 'general', 'Kandangan', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banjarmasin', 'Kantor Wilayah DJKN Kalimantan Selatan Dan Tengah', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (538, 15, '005011500099219000KD', 'PENGADILAN NEGERI KOTABARU', 'general', 'Kotabaru', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banjarmasin', 'Kantor Wilayah DJKN Kalimantan Selatan Dan Tengah', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (539, 15, '005011500099223000KD', 'PENGADILAN NEGERI BARABAI', 'general', 'Barabai', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banjarmasin', 'Kantor Wilayah DJKN Kalimantan Selatan Dan Tengah', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (540, 15, '005011500099251000KD', 'PENGADILAN NEGERI AMUNTAI', 'general', 'Amuntai', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banjarmasin', 'Kantor Wilayah DJKN Kalimantan Selatan Dan Tengah', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (541, 15, '005011500099265000KD', 'PN RANTAU', 'general', 'Rantau', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banjarmasin', 'Kantor Wilayah DJKN Kalimantan Selatan Dan Tengah', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (542, 15, '005011500307101000KD', 'PENGADILAN AGAMA MARABAHAN', 'general', 'Marabahan', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banjarmasin', 'Kantor Wilayah DJKN Kalimantan Selatan Dan Tengah', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (543, 15, '005011500307115000KD', 'PENGADILAN AGAMA PELAIHARI', 'general', 'Pelaihari', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banjarmasin', 'Kantor Wilayah DJKN Kalimantan Selatan Dan Tengah', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (544, 15, '005011500307122000KD', 'PENGADILAN AGAMA KOTABARU', 'general', 'Kotabaru', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banjarmasin', 'Kantor Wilayah DJKN Kalimantan Selatan Dan Tengah', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (545, 15, '005011500400260000KD', 'PENGADILAN NEGERI MARABAHAN', 'general', 'Marabahan', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banjarmasin', 'Kantor Wilayah DJKN Kalimantan Selatan Dan Tengah', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (546, 15, '005011500400282000KD', 'PENGADILAN NEGERI PELAIHARI', 'general', 'Pleihari', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banjarmasin', 'Kantor Wilayah DJKN Kalimantan Selatan Dan Tengah', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (547, 15, '005011500402449000KD', 'PENGADILAN TINGGI AGAMA BANJARMASIN', 'tingkatbanding', 'Banjarmasin', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banjarmasin', 'Kantor Wilayah DJKN Kalimantan Selatan Dan Tengah', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (548, 15, '005011500402519000KD', 'PENGADILAN AGAMA MARTAPURA', 'general', 'Martapura', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banjarmasin', 'Kantor Wilayah DJKN Kalimantan Selatan Dan Tengah', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (549, 15, '005011500402525000KD', 'PENGADILAN AGAMA RANTAU', 'general', 'Rantau', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banjarmasin', 'Kantor Wilayah DJKN Kalimantan Selatan Dan Tengah', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (550, 15, '005011500402540000KD', 'PA BARABAI', 'general', 'Barabai', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banjarmasin', 'Kantor Wilayah DJKN Kalimantan Selatan Dan Tengah', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (551, 15, '005011500402562000KD', 'PENGADILAN AGAMA TANJUNG', 'general', 'Tanjung', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banjarmasin', 'Kantor Wilayah DJKN Kalimantan Selatan Dan Tengah', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (552, 15, '005011500531865000KD', 'PTUN BANJARMASIN (01)', 'general', 'Banjarmasin', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banjarmasin', 'Kantor Wilayah DJKN Kalimantan Selatan Dan Tengah', 'PT', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (553, 15, '005011500632043000KD', 'PENGADILAN AGAMA BANJARBARU', 'general', 'Banjarbaru', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banjarmasin', 'Kantor Wilayah DJKN Kalimantan Selatan Dan Tengah', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (554, 15, '005011500653458000KD', 'PENGADILAN NEGERI BANJARBARU', 'general', 'Banjarbaru', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banjarmasin', 'Kantor Wilayah DJKN Kalimantan Selatan Dan Tengah', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (555, 15, '005011500663232000KD', 'PENGADILAN MILITER I-06 BANJARMASIN', 'general', 'Banjarmasin', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banjarmasin', 'Kantor Wilayah DJKN Kalimantan Selatan Dan Tengah', 'PM', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (556, 15, '005011500670206000KD', 'PENGADILAN NEGERI BATULICIN', 'general', 'Batulicin', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banjarmasin', 'Kantor Wilayah DJKN Kalimantan Selatan Dan Tengah', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (557, 15, '005011500682260000KD', 'PENGADILAN AGAMA BATULICIN', 'general', 'Batu Licin', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banjarmasin', 'Kantor Wilayah DJKN Kalimantan Selatan Dan Tengah', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (558, 16, '005011600099286000KD', 'PENGADILAN NEGERI SAMARINDA', 'general', 'Samarinda', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Samarinda', 'Kantor Wilayah DJKN Kalimantan Timur Dan Utara', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (559, 16, '005011600099290000KD', 'PENGADILAN NEGERI TENGGARONG', 'general', 'Tenggarong', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Samarinda', 'Kantor Wilayah DJKN Kalimantan Timur Dan Utara', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (560, 16, '005011600099308000KD', 'PENGADILAN NEGERI BALIKPAPAN (01)', 'general', 'Balikpapan', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Balikpapan', 'Kantor Wilayah DJKN Kalimantan Timur Dan Utara', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (561, 16, '005011600307161000KD', 'PA TENGGARONG', 'general', 'Tenggarong', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Samarinda', 'Kantor Wilayah DJKN Kalimantan Timur Dan Utara', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (562, 16, '005011600307178000KD', 'PENGADILAN AGAMA SAMARINDA', 'general', 'Samarinda', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Samarinda', 'Kantor Wilayah DJKN Kalimantan Timur Dan Utara', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (563, 16, '005011600307182000KD', 'PENGADILAN AGAMA TANAH GROGOT', 'general', 'Tanah Grogot', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Balikpapan', 'Kantor Wilayah DJKN Kalimantan Timur Dan Utara', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (564, 16, '005011600307199000KD', 'PENGADILAN AGAMA BALIKPAPAN', 'general', 'Balikpapan', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Balikpapan', 'Kantor Wilayah DJKN Kalimantan Timur Dan Utara', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (565, 16, '005011600307204000KD', 'PENGADILAN AGAMA TANJUNG REDEB', 'general', 'Tanjung Redep', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Tarakan', 'Kantor Wilayah DJKN Kalimantan Timur Dan Utara', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (566, 16, '005011600400302000KD', 'PENGADILAN NEGERI TANAH GROGOT', 'general', 'Tanah Grogot', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Balikpapan', 'Kantor Wilayah DJKN Kalimantan Timur Dan Utara', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (567, 16, '005011600400528000KD', 'PENGADILAN TINGGI SAMARINDA', 'tingkatbanding', 'Samarinda', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Samarinda', 'Kantor Wilayah DJKN Kalimantan Timur Dan Utara', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (568, 16, '005011600402480000KD', 'PENGADILAN TINGGI AGAMA SAMARINDA', 'tingkatbanding', 'Samarinda', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Samarinda', 'Kantor Wilayah DJKN Kalimantan Timur Dan Utara', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (569, 16, '005011600477380000KD', 'PENGADILAN NEGERI KUTAI BARAT', 'general', 'Kutai Barat', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Samarinda', 'Kantor Wilayah DJKN Kalimantan Timur Dan Utara', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (570, 16, '005011600652080000KD', 'PENGADILAN AGAMA BONTANG', 'general', 'Bontang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bontang', 'Kantor Wilayah DJKN Kalimantan Timur Dan Utara', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (571, 16, '005011600652097000KD', 'PENGADILAN AGAMA SANGATTA (01)', 'general', 'Sangatta', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bontang', 'Kantor Wilayah DJKN Kalimantan Timur Dan Utara', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (572, 16, '005011600662972000KD', 'PENGADILAN NEGERI BONTANG', 'general', 'Bontang', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bontang', 'Kantor Wilayah DJKN Kalimantan Timur Dan Utara', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (573, 16, '005011600663246000KD', 'PENGADILAN MILITER I-07 BALIKPAPAN', 'general', 'Balikpapan', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', 'Kantor Pelayanan Kekayaan Negara dan Lelang Balikpapan', 'Kantor Wilayah DJKN Kalimantan Timur Dan Utara', 'PM', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (574, 17, '005011700099312000KD', 'PENGADILAN TINGGI MANADO', 'tingkatbanding', 'Manado', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Manado', 'Kantor Wilayah DJKN Sulawesi Utara, Tengah, Gorontalo Dan Maluku Utara', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (575, 17, '005011700099333000KD', 'PENGADILAN NEGERI KOTAMOBAGU', 'general', 'Kotamubago', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Manado', 'Kantor Wilayah DJKN Sulawesi Utara, Tengah, Gorontalo Dan Maluku Utara', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (576, 17, '005011700099354000KD', 'PENGADILAN NEGERI TONDANO', 'general', 'Tondano', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Manado', 'Kantor Wilayah DJKN Sulawesi Utara, Tengah, Gorontalo Dan Maluku Utara', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (577, 17, '005011700307225000KD', 'PENGADILAN AGAMA MANADO', 'general', 'Manado', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Manado', 'Kantor Wilayah DJKN Sulawesi Utara, Tengah, Gorontalo Dan Maluku Utara', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (578, 17, '005011700307232000KD', 'PENGADILAN AGAMA KOTAMOBAGU', 'general', 'Kotamubagu', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Manado', 'Kantor Wilayah DJKN Sulawesi Utara, Tengah, Gorontalo Dan Maluku Utara', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (579, 17, '005011700307246000KD', 'PENGADILAN AGAMA TAHUNA', 'general', 'Tahuna', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Manado', 'Kantor Wilayah DJKN Sulawesi Utara, Tengah, Gorontalo Dan Maluku Utara', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (580, 17, '005011700402681000KD', 'PENGADILAN TINGGI AGAMA MANADO', 'tingkatbanding', 'Manado', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Manado', 'Kantor Wilayah DJKN Sulawesi Utara, Tengah, Gorontalo Dan Maluku Utara', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (581, 17, '005011700402701000KD', 'PENGADILAN AGAMA TONDANO', 'general', 'Tondano', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Manado', 'Kantor Wilayah DJKN Sulawesi Utara, Tengah, Gorontalo Dan Maluku Utara', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (582, 17, '005011700568725000KD', 'PENGADILAN NEGERI BITUNG', 'general', 'Bitung', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Manado', 'Kantor Wilayah DJKN Sulawesi Utara, Tengah, Gorontalo Dan Maluku Utara', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (583, 17, '005011700604751000KD', 'PENGADILAN AGAMA BITUNG', 'general', 'Bitung', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Manado', 'Kantor Wilayah DJKN Sulawesi Utara, Tengah, Gorontalo Dan Maluku Utara', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (584, 17, '005011700663360000KD', 'PENGADILAN MILITER III-17 MANADO', 'general', 'Manado', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', 'Kantor Pelayanan Kekayaan Negara dan Lelang Manado', 'Kantor Wilayah DJKN Sulawesi Utara, Tengah, Gorontalo Dan Maluku Utara', 'PM', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (585, 17, '005011700670210000KD', 'PENGADILAN NEGERI AIRMADIDI', 'general', 'Airmadidi', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Manado', 'Kantor Wilayah DJKN Sulawesi Utara, Tengah, Gorontalo Dan Maluku Utara', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (586, 17, '005011700673034000KD', 'PENGADILAN NEGERI AMURANG', 'general', 'Amurang', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Manado', 'Kantor Wilayah DJKN Sulawesi Utara, Tengah, Gorontalo Dan Maluku Utara', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (587, 17, '005011700682171000KD', 'PENGADILAN AGAMA AMURANG', 'general', 'Amurang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Manado', 'Kantor Wilayah DJKN Sulawesi Utara, Tengah, Gorontalo Dan Maluku Utara', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (588, 18, '005011800099375000KD', 'PENGADILAN NEGERI PALU', 'general', 'Palu', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Palu', 'Kantor Wilayah DJKN Sulawesi Utara, Tengah, Gorontalo Dan Maluku Utara', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (589, 18, '005011800099382000KD', 'PENGADILAN NEGERI TOLITOLI', 'general', 'Toli-Toli', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Palu', 'Kantor Wilayah DJKN Sulawesi Utara, Tengah, Gorontalo Dan Maluku Utara', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (590, 18, '005011800099396000KD', 'PN LUWUK', 'general', 'Luwuk', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Palu', 'Kantor Wilayah DJKN Sulawesi Utara, Tengah, Gorontalo Dan Maluku Utara', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (591, 18, '005011800099401000KD', 'PENGADILAN NEGERI POSO', 'general', 'Poso', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Palu', 'Kantor Wilayah DJKN Sulawesi Utara, Tengah, Gorontalo Dan Maluku Utara', 'PN', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (592, 18, '005011800307271000KD', 'PENGADILAN AGAMA PALU', 'general', 'Kodya Palu', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Palu', 'Kantor Wilayah DJKN Sulawesi Utara, Tengah, Gorontalo Dan Maluku Utara', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (593, 18, '005011800307288000KD', 'PENGADILAN AGAMA TOLITOLI', 'general', 'Toli Toli', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Palu', 'Kantor Wilayah DJKN Sulawesi Utara, Tengah, Gorontalo Dan Maluku Utara', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (594, 18, '005011800307292000KD', 'PA. POSO', 'general', 'Poso', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Palu', 'Kantor Wilayah DJKN Sulawesi Utara, Tengah, Gorontalo Dan Maluku Utara', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (595, 18, '005011800307300000KD', 'PENGADILAN AGAMA LUWUK', 'general', 'Luwuk', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Palu', 'Kantor Wilayah DJKN Sulawesi Utara, Tengah, Gorontalo Dan Maluku Utara', 'PA', NULL, '2018-12-05 19:50:07', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (596, 18, '005011800400534000KD', 'PENGADILAN TINGGI SULAWESI TENGAH', 'tingkatbanding', 'Palu', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Palu', 'Kantor Wilayah DJKN Sulawesi Utara, Tengah, Gorontalo Dan Maluku Utara', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (597, 18, '005011800477202000KD', 'PENGADILAN NEGERI DONGGALA', 'general', 'Donggala', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Palu', 'Kantor Wilayah DJKN Sulawesi Utara, Tengah, Gorontalo Dan Maluku Utara', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (598, 18, '005011800576249000KD', 'PENGADILAN TINGGI AGAMA PALU', 'tingkatbanding', 'Palu', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Palu', 'Kantor Wilayah DJKN Sulawesi Utara, Tengah, Gorontalo Dan Maluku Utara', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (599, 18, '005011800578850000KD', 'PENGADILAN TATA USAHA NEGARA PALU', 'general', 'Palu', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', 'Kantor Pelayanan Kekayaan Negara dan Lelang Palu', 'Kantor Wilayah DJKN Sulawesi Utara, Tengah, Gorontalo Dan Maluku Utara', 'PT', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (600, 18, '005011800604765000KD', 'PENGADILAN AGAMA DONGGALA', 'general', 'Palu Kab. Donggala', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Palu', 'Kantor Wilayah DJKN Sulawesi Utara, Tengah, Gorontalo Dan Maluku Utara', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (601, 18, '005011800652102000KD', 'PENGADILAN AGAMA BUOL', 'general', 'Buol', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Palu', 'Kantor Wilayah DJKN Sulawesi Utara, Tengah, Gorontalo Dan Maluku Utara', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (602, 18, '005011800652119000KD', 'PENGADILAN AGAMA BUNGKU', 'general', 'Bungku', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Palu', 'Kantor Wilayah DJKN Sulawesi Utara, Tengah, Gorontalo Dan Maluku Utara', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (603, 18, '005011800652123000KD', 'PENGADILAN AGAMA BANGGAI', 'general', 'Banggai', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Palu', 'Kantor Wilayah DJKN Sulawesi Utara, Tengah, Gorontalo Dan Maluku Utara', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (604, 18, '005011800670248000KD', 'PENGADILAN NEGERI BUOL', 'general', 'Buol', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Palu', 'Kantor Wilayah DJKN Sulawesi Utara, Tengah, Gorontalo Dan Maluku Utara', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (605, 18, '005011800672980000KD', 'PENGADILAN NEGERI PARIGI', 'general', 'Parigi', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Palu', 'Kantor Wilayah DJKN Sulawesi Utara, Tengah, Gorontalo Dan Maluku Utara', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (606, 18, '005011800682192000KD', 'PENGADILAN AGAMA PARIGI', 'general', 'Parigi', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Palu', 'Kantor Wilayah DJKN Sulawesi Utara, Tengah, Gorontalo Dan Maluku Utara', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (607, 19, '005011900099418000KD', 'PENGADILAN TINGGI MAKASSAR', 'tingkatbanding', 'Ujung Pandang', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Makasar', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (608, 19, '005011900099422000KD', 'PENGADILAN NEGERI MAKASSAR', 'general', 'Ujung Pandang', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Makasar', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (609, 19, '005011900099439000KD', 'Pengadilan Negeri Sungguminasa', 'general', 'Sungguminasa', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Makasar', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (610, 19, '005011900099443000KD', 'PENGADILAN NEGERI PANGKAJENE', 'general', 'Pangkajene', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Makasar', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (611, 19, '005011900099450000KD', 'PENGADILAN NEGERI BARRU', 'general', 'Barru', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pare-Pare', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (612, 19, '005011900099471000KD', 'PENGADILAN NEGERI MAROS', 'general', 'Maros', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Makasar', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (613, 19, '005011900099485000KD', 'PENGADILAN NEGERI JENEPONTO', 'general', 'Jeneponto', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Makasar', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (614, 19, '005011900099492000KD', 'PENGADILAN NEGERI PAREPARE', 'general', 'Pare-Pare', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pare-Pare', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (615, 19, '005011900099507000KD', 'PENGADILAN NEGERI ENREKANG', 'general', 'Enrekang', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Palopo', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (616, 19, '005011900099511000KD', 'PENGADILAN NEGERI SIDRAP', 'general', 'Sidenreng Rappang', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pare-Pare', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (617, 19, '005011900099532000KD', 'PENGADILAN NEGERI WATAMPONE 01', 'general', 'Watampone', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pare-Pare', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (618, 19, '005011900099549000KD', 'PENGADILAN NEGERI WATANSOPPENG', 'general', 'Watansopeng', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pare-Pare', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (619, 19, '005011900099553000KD', 'PENGADILAN NEGERI SENGKANG', 'general', 'Sengkang', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pare-Pare', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (620, 19, '005011900099574000KD', 'PENGADILAN  NEGERI  SINJAI', 'general', 'Sinjai', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Makasar', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (621, 19, '005011900099581000KD', 'PENGADILAN NEGERI BULUKUMBA', 'general', 'Bulukumba', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Makasar', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (622, 19, '005011900099595000KD', 'PENGADILAN NEGERI SELAYAR', 'general', 'Selayar', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Makasar', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (623, 19, '005011900099600000KD', 'PENGADILAN NEGERI KELAS I B PALOPO', 'general', 'Palopo', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Palopo', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (624, 19, '005011900307431000KD', 'PENGADILAN AGAMA PANGKAJENE', 'general', 'Pangkajene', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Makasar', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (625, 19, '005011900307466000KD', 'PENGADILAN AGAMA JENEPONTO', 'general', 'Jenneponto', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Makasar', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (626, 19, '005011900307487000KD', 'PENGADILAN AGAMA BARRU', 'general', 'Barru', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pare-Pare', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (627, 19, '005011900307491000KD', 'PENGADILAN AGAMA SUNGGUMINASA', 'general', 'Sungguminasa', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Makasar', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (628, 19, '005011900307509000KD', 'PENGADILAN AGAMA WATAMPONE', 'general', 'Watampone', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pare-Pare', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (629, 19, '005011900307513000KD', 'PENGADILAN AGAMA SENGKANG', 'general', 'Sengkang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pare-Pare', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (630, 19, '005011900307520000KD', 'PENGADILAN AGAMA WATANSOPPENG', 'general', 'Watan Soppeng', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pare-Pare', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (631, 19, '005011900307534000KD', 'PENGADILAN AGAMA BANTAENG', 'general', 'Bantaeng', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Makasar', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (632, 19, '005011900307541000KD', 'PENGADILAN AGAMA BULUKUMBA', 'general', 'Bulukumba', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Makasar', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (633, 19, '005011900307555000KD', 'PENGADILAN AGAMA SINJAI', 'general', 'Sinjai', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Makasar', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (634, 19, '005011900307562000KD', 'PENGADILAN AGAMA SELAYAR', 'general', 'Selayar', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Makasar', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (635, 19, '005011900307576000KD', 'PENGADDILAN AGAMA PAREPARE', 'general', 'Pare Pare', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pare-Pare', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (636, 19, '005011900307580000KD', 'PENGADILAN AGAMA PINRANG', 'general', 'Pinrang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pare-Pare', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (637, 19, '005011900307602000KD', 'PENGADILAN AGAMA SIDRAP', 'general', 'Sidenreng', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pare-Pare', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (638, 19, '005011900307619000KD', 'PENGADILAN AGAMA PALOPO', 'general', 'Palopo', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Palopo', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (639, 19, '005011900307623000KD', 'Pengadilan Agama Makale', 'general', 'Makale', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Palopo', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (640, 19, '005011900526711000KD', 'PENGADILAN TINGGI TUN MAKASSAR', 'tingkatbanding', 'Makassar', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', 'Kantor Pelayanan Kekayaan Negara dan Lelang Makasar', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (641, 19, '005011900526771000KD', 'PENGADILAN TATA USAHA NEGARA MAKASSAR', 'general', 'Makassar', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', 'Kantor Pelayanan Kekayaan Negara dan Lelang Makasar', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PT', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (642, 19, '005011900632050000KD', 'PENGADILAN AGAMA MASAMBA', 'general', 'Masamba', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Palopo', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (643, 19, '005011900663356000KD', 'PENGADILAN MILITER III-16 MAKASSAR', 'general', 'Makassar', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', 'Kantor Pelayanan Kekayaan Negara dan Lelang Makasar', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PM', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (644, 19, '005011900672927000KD', 'PENGADILAN NEGERI MASAMBA', 'general', 'Masamba', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Palopo', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (645, 20, '005012000099659000KD', 'PENGADILAN NEGERI KENDARI', 'general', 'Kendari', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kendari', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (646, 20, '005012000099663000KD', 'PENGADILAN NEGERI BAUBAU KELAS IB', 'general', 'Bau-Bau', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kendari', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (647, 20, '005012000099670000KD', 'PENGADILAN NEGERI RAHA', 'general', 'Raha', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kendari', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (648, 20, '005012000099684000KD', 'PENGADILAN NEGERI KOLAKA', 'general', 'Kolaka', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kendari', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (649, 20, '005012000307690000KD', 'PENGADILAN AGAMA KOLAKA', 'general', 'Kolaka', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kendari', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (650, 20, '005012000307708000KD', 'PENGADILAN AGAMA RAHA', 'general', 'Raha', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kendari', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (651, 20, '005012000307712000KD', 'PENGADILAN AGAMA KENDARI', 'general', 'Kendari', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kendari', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (652, 20, '005012000307729000KD', 'PENGADILAN  AGAMA BAUBAU', 'general', 'Bau-Bau', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kendari', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (653, 20, '005012000576253000KD', 'PENGADILAN TINGGI AGAMA KENDARI', 'tingkatbanding', 'Kendari', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kendari', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (654, 20, '005012000578864000KD', 'PTUN KENDARI', 'general', 'Kendari', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kendari', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PT', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (655, 20, '005012000604772000KD', 'PENGADILAN AGAMA UNAAHA', 'general', 'Unaaha', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kendari', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (656, 20, '005012000681439000KD', 'PENGADILAN NEGERI ANDOOLO', 'general', 'Andoolo', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kendari', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (657, 20, '005012000681443000KD', 'PENGADILAN NEGERI PASARWAJO', 'general', 'Pasarwajo', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kendari', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (658, 20, '005012000682207000KD', 'PENGADILAN AGAMA ANDOOLO', 'general', 'Andoolo', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kendari', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (659, 20, '005012000682211000KD', 'PENGADILAN AGAMA PASARWAJO', 'general', 'Pasarwajo', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kendari', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (660, 21, '005012100099691000KD', 'PENGADILAN TINGGI AMBON', 'tingkatbanding', 'Ambon', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Ambon', 'Kantor Wilayah DJKN Papua, Papua Barat Dan Maluku', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (661, 21, '005012100099706000KD', 'PENGADILAN NEGERI AMBON', 'general', 'Ambon', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Ambon', 'Kantor Wilayah DJKN Papua, Papua Barat Dan Maluku', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (662, 21, '005012100099710000KD', 'PENGADILAN NEGARI MASOHI', 'general', 'Masohi', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Ambon', 'Kantor Wilayah DJKN Papua, Papua Barat Dan Maluku', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (663, 21, '005012100099727000KD', 'PENGADILAN NEGERI TUAL', 'general', 'Tual', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Ambon', 'Kantor Wilayah DJKN Papua, Papua Barat Dan Maluku', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (664, 21, '005012100307754000KD', 'PENGADILAN AGAMA AMBON', 'general', 'Ambon', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Ambon', 'Kantor Wilayah DJKN Papua, Papua Barat Dan Maluku', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (665, 21, '005012100307761000KD', 'PENGADILAN AGAMA TUAL', 'general', 'Tual', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Ambon', 'Kantor Wilayah DJKN Papua, Papua Barat Dan Maluku', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (666, 21, '005012100307775000KD', 'PENGADILAN AGAMA MASOHI', 'general', 'Masohi', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Ambon', 'Kantor Wilayah DJKN Papua, Papua Barat Dan Maluku', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (667, 21, '005012100402710000KD', 'PENGADILAN TINGGI AGAMA AMBON', 'tingkatbanding', 'Ambon', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Ambon', 'Kantor Wilayah DJKN Papua, Papua Barat Dan Maluku', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (668, 21, '005012100663377000KD', 'PENGADILAN MILITER III-18 AMBON', 'general', 'Ambon', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', 'Kantor Pelayanan Kekayaan Negara dan Lelang Ambon', 'Kantor Wilayah DJKN Papua, Papua Barat Dan Maluku', 'PM', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (669, 21, '005012100672931000KD', 'PENGADILAN NEGERI SAUMLAKI', 'general', 'Saumlaki', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Ambon', 'Kantor Wilayah DJKN Papua, Papua Barat Dan Maluku', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (670, 22, '005012200099773000KD', 'PENGADILAN TINGGI DENPASAR', 'tingkatbanding', 'Denpasar', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Denpasar', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (671, 22, '005012200099780000KD', 'Pengadilan Negeri Denpasar', 'general', 'Denpasar', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Denpasar', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (672, 22, '005012200099794000KD', 'PENGADILAN NEGERI SINGARAJA', 'general', 'Singaraja', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Singaraja', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (673, 22, '005012200099816000KD', 'PENGADILAN NEGERI SEMARAPURA', 'general', 'Klungkung', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Denpasar', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (674, 22, '005012200099820000KD', 'PENGADILAN NEGERI TABANAN', 'general', 'Tabanan', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Denpasar', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (675, 22, '005012200099837000KD', 'PENGADILAN NEGERI AMLAPURA', 'general', 'Karangasem', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Singaraja', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (676, 22, '005012200099841000KD', 'PENGADILAN NEGERI GIANYAR', 'general', 'Gianyar', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Denpasar', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (677, 22, '005012200307822000KD', 'PENGADILAN AGAMA DENPASAR', 'general', 'Denpasar', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Denpasar', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (678, 22, '005012200307839000KD', 'PENGADILAN AGAMA SINGARAJA', 'general', 'Singaraja', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Singaraja', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (679, 22, '005012200402726000KD', 'PENGADILAN AGAMA BANGLI', 'general', 'Bangli', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Singaraja', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (680, 22, '005012200402732000KD', 'PENGADILAN AGAMA NEGARA', 'general', 'Negara', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Singaraja', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (681, 22, '005012200402741000KD', 'PENGADILAN AGAMA KARANGASEM', 'general', 'Karangasem', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Singaraja', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (682, 22, '005012200402757000KD', 'PENGADILAN AGAMA TABANAN', 'general', 'Tabanan', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Denpasar', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (683, 22, '005012200402763000KD', 'PENGADILAN AGAMA KLUNGKUNG', 'general', 'Klungkung', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Denpasar', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (684, 22, '005012200559861000KD', 'PENGADILAN TUN DENPASAR', 'general', 'Denpasar', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', 'Kantor Pelayanan Kekayaan Negara dan Lelang Denpasar', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PT', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (685, 22, '005012200614731000KD', 'PENGADILAN AGAMA BADUNG', 'general', 'Badung', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Denpasar', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (686, 22, '005012200663335000KD', 'PENGADILAN MILITER III-14 DENPASAR', 'general', 'Denpasar', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', 'Kantor Pelayanan Kekayaan Negara dan Lelang Denpasar', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PM', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (687, 23, '005012300099862000KD', 'PN MATARAM', 'general', 'Mataram', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Mataram', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (688, 23, '005012300099883000KD', 'PENGADILAN NEGERI SUMBAWA BESAR (01)', 'general', 'Sumbawa Besar', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bima', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (689, 23, '005012300099890000KD', 'PENGADILAN NEGERI SELONG', 'general', 'Selong', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Mataram', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (690, 23, '005012300099912000KD', 'PENGADILAN NEGERI PRAYA', 'general', 'Praya', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Mataram', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (691, 23, '005012300307907000KD', 'PENGADILAN AGAMA PRAYA', 'general', 'Praya', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Mataram', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (692, 23, '005012300307911000KD', 'PENGADILAN AGAMA SELONG', 'general', 'Selong', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Mataram', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (693, 23, '005012300307928000KD', 'PENGADILAN AGAMA BIMA (01)', 'general', 'Bima', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bima', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (694, 23, '005012300307932000KD', 'PENGADILAN AGAMA DOMPU (01)', 'general', 'Dompu', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bima', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (695, 23, '005012300400559000KD', 'PENGADILAN TINGGI MATARAM', 'tingkatbanding', 'Mataram', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Mataram', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (696, 23, '005012300402788000KD', 'PTA MATARAM', 'general', 'Mataram', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Mataram', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (697, 23, '005012300578871000KD', 'PENGADILAN TATA USAHA NEGARA MATARAM', 'general', 'Mataram', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', 'Kantor Pelayanan Kekayaan Negara dan Lelang Mataram', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PT', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (698, 23, '005012300682274000KD', 'PENGADILAN AGAMA TALIWANG (01)', 'general', 'Taliwang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bima', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (699, 24, '005012400099926000KD', 'PN KUPANG', 'general', 'Kupang', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kupang', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (700, 24, '005012400099930000KD', 'PENGADILAN NEGERI ATAMBUA', 'general', 'Atambua', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kupang', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (701, 24, '005012400099947000KD', 'PENGADILAN NEGERI SOE', 'general', 'So\'E', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kupang', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (702, 24, '005012400099951000KD', 'PENGADILAN NEGERI KEFAMENANU', 'general', 'Kefamenanu', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kupang', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (703, 24, '005012400099968000KD', 'PENGADILAN NEGERI WAINGAPU', 'general', 'Waingapu', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kupang', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (704, 24, '005012400099972000KD', 'PENGADILAN NEGERI WAIKABUBAK', 'general', 'Waikabubak', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kupang', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (705, 24, '005012400099989000KD', 'PENGADILAN NEGERI ENDE', 'general', 'Ende', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kupang', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (706, 24, '005012400099993000KD', 'PENGADILAN NEGERI MAUMERE', 'general', 'Maumere', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kupang', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (707, 24, '005012400307949000KD', 'PENGADILAN AGAMA WAIKABUBAK', 'general', 'Waikabubak', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kupang', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (708, 24, '005012400307953000KD', 'PENGADILAN AGAMA KUPANG', 'general', 'Kupang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kupang', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (709, 24, '005012400307960000KD', 'PA KALABAHI', 'general', 'Kalabahi', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kupang', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (710, 24, '005012400307974000KD', 'PENGADILAN AGAMA ENDE', 'general', 'Ende', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kupang', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (711, 24, '005012400307981000KD', 'PENGADILAN AGAMA WAINGAPU', 'general', 'Waingapu', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kupang', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (712, 24, '005012400400007000KD', 'PENGADILAN NEGERI LARANTUKA', 'general', 'Larantuka', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kupang', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (713, 24, '005012400400013000KD', 'PENGADILAN NEGERI RUTENG', 'general', 'Ruteng', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kupang', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (714, 24, '005012400400163000KD', 'PENGADILAN NEGERI KALABAHI', 'general', 'Kalabahi', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kupang', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (715, 24, '005012400400245000KD', 'PENGADILAN TINGGI KUPANG', 'tingkatbanding', 'Kupang', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kupang', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (716, 24, '005012400402794000KD', 'PENGADILAN AGAMA LARANTUKA', 'general', 'Larantuka', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kupang', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (717, 24, '005012400402808000KD', 'PENGADILAN AGAMA RUTENG', 'general', 'Ruteng', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kupang', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (718, 24, '005012400402814000KD', 'PENGADILAN AGAMA ATAMBUA', 'general', 'Atambua', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kupang', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (719, 24, '005012400402820000KD', 'PENGADILAN AGAMA SOE', 'general', 'Soe', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kupang', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (720, 24, '005012400402839000KD', 'PENGADILAN AGAMA KEFAMENANU', 'general', 'Kefamenanu', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kupang', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (721, 24, '005012400402845000KD', 'PENGADILAN AGAMA BAJAWA', 'general', 'Bajawa', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kupang', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (722, 24, '005012400477230000KD', 'PENGADILAN NEGERI LEMBATA', 'general', 'Lembata', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kupang', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (723, 24, '005012400477249000KD', 'PENGADILAN NEGERI ROTE NDAO', 'general', 'Rote Ndao', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kupang', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (724, 24, '005012400539121000KD', 'PENGADILAN TATA USAHA NEGARA KUPANG', 'general', 'Kupang', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kupang', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PT', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (725, 24, '005012400576260000KD', 'Pengadilan Tinggi Agama NTT', 'tingkatbanding', 'Kupang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kupang', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (726, 24, '005012400632064000KD', 'PENGADILAN AGAMA LEWOLEBA', 'general', 'Lewoleba', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kupang', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (727, 24, '005012400663342000KD', 'PENGADILAN MILITER III-15 KUPANG', 'general', 'Kupang', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kupang', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PM', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (728, 24, '005012400673020000KD', 'PENGADILAN NEGERI LABUAN BAJO', 'general', 'Labuan Bajo', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kupang', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (729, 24, '005012400681418000KD', 'PENGADILAN NEGERI OELAMASI', 'general', 'Oelamasi', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kupang', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (730, 24, '005012400682281000KD', 'PENGADILAN AGAMA LABUAN BAJO', 'general', 'Labuan Bajo', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kupang', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (731, 25, '005012500400022000KD', 'PENGADILAN TINGGI JAYAPURA', 'tingkatbanding', 'Jayapura', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jayapura', 'Kantor Wilayah DJKN Papua, Papua Barat Dan Maluku', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (732, 25, '005012500400038000KD', 'PENGADILAN NEGERI JAYAPURA', 'general', 'Jayapura', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jayapura', 'Kantor Wilayah DJKN Papua, Papua Barat Dan Maluku', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (733, 25, '005012500400044000KD', 'PENGADILAN NEGERI WAMENA (01)', 'general', 'Wamena', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jayapura', 'Kantor Wilayah DJKN Papua, Papua Barat Dan Maluku', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (734, 25, '005012500400050000KD', 'PENGADILAN NEGERI MERAUKE', 'general', 'Merauke', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jayapura', 'Kantor Wilayah DJKN Papua, Papua Barat Dan Maluku', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (735, 25, '005012500400090000KD', 'PENGADILAN NEGERI BIAK (01)', 'general', 'Biak', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Biak', 'Kantor Wilayah DJKN Papua, Papua Barat Dan Maluku', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (736, 25, '005012500400101000KD', 'PENGADILAN NEGERI NABIRE (01)', 'general', 'Nabire', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Biak', 'Kantor Wilayah DJKN Papua, Papua Barat Dan Maluku', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (737, 25, '005012500402876000KD', 'PENGADILAN AGAMA JAYAPURA', 'general', 'Jayapura', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jayapura', 'Kantor Wilayah DJKN Papua, Papua Barat Dan Maluku', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (738, 25, '005012500614890000KD', 'PENGADILAN NEGERI KOTA TIMIKA', 'general', 'Kota Timika Kabupaten Mimika', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jayapura', 'Kantor Wilayah DJKN Papua, Papua Barat Dan Maluku', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (739, 25, '005012500663381000KD', 'PENGADILAN MILITER III-19 JAYAPURA', 'general', 'Jayapura', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jayapura', 'Kantor Wilayah DJKN Papua, Papua Barat Dan Maluku', 'PM', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (740, 25, '005012500682300000KD', 'PENGADILAN AGAMA ARSO', 'general', 'Arso', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jayapura', 'Kantor Wilayah DJKN Papua, Papua Barat Dan Maluku', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (741, 26, '005012600308014000KD', 'PENGADILAN AGAMA MANNA', 'general', 'Manna', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bengkulu', 'Kantor Wilayah DJKN Lampung Dan Bengkulu', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (742, 26, '005012600308035000KD', 'PENGADILAN AGAMA ARGA MAKMUR', 'general', 'Argamakmur', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bengkulu', 'Kantor Wilayah DJKN Lampung Dan Bengkulu', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (743, 26, '005012600308152000KD', 'PENGADILAN AGAMA BENGKULU', 'general', 'Bengkulu', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bengkulu', 'Kantor Wilayah DJKN Lampung Dan Bengkulu', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (744, 26, '005012600400110000KD', 'PENGADILAN NEGERI BENGKULU', 'general', 'Bengkulu', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bengkulu', 'Kantor Wilayah DJKN Lampung Dan Bengkulu', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (745, 26, '005012600400126000KD', 'PENGADILAN NEGERI CURUP', 'general', 'Curup', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bengkulu', 'Kantor Wilayah DJKN Lampung Dan Bengkulu', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (746, 26, '005012600400132000KD', 'PENGADILAN NEGERI MANNA 01', 'general', 'Manna', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bengkulu', 'Kantor Wilayah DJKN Lampung Dan Bengkulu', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (747, 26, '005012600400512000KD', 'PENGADILAN TINGGI BENGKULU', 'tingkatbanding', 'Bengkulu', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bengkulu', 'Kantor Wilayah DJKN Lampung Dan Bengkulu', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (748, 26, '005012600576274000KD', 'Pengadilan Tinggi Agama Bengkulu', 'tingkatbanding', 'Bengkulu', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bengkulu', 'Kantor Wilayah DJKN Lampung Dan Bengkulu', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (749, 26, '005012600673009000KD', 'PENGADILAN NEGERI TAIS', 'general', 'Tais', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bengkulu', 'Kantor Wilayah DJKN Lampung Dan Bengkulu', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (750, 26, '005012600673041000KD', 'PENGADILAN NEGERI KEPAHIANG', 'general', 'Kepahiang', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bengkulu', 'Kantor Wilayah DJKN Lampung Dan Bengkulu', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (751, 26, '005012600673055000KD', 'PENGADILAN NEGERI TUBEI', 'general', 'Tubei', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bengkulu', 'Kantor Wilayah DJKN Lampung Dan Bengkulu', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (752, 26, '005012600682253000KD', 'PENGADILAN AGAMA LEBONG', 'general', 'Lebong', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bengkulu', 'Kantor Wilayah DJKN Lampung Dan Bengkulu', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (753, 27, '005012800099731000KD', 'PENGADILAN NEGERI TERNATE', 'general', 'Ternate', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Ternate', 'Kantor Wilayah DJKN Sulawesi Utara, Tengah, Gorontalo Dan Maluku Utara', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (754, 27, '005012800099752000KD', 'PENGADILAN NEGERI LABUHA', 'general', 'Labuha', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Ternate', 'Kantor Wilayah DJKN Sulawesi Utara, Tengah, Gorontalo Dan Maluku Utara', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (755, 27, '005012800099769000KD', 'PENGADILAN NEGERI SOASIO', 'general', 'Soasiu', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Ternate', 'Kantor Wilayah DJKN Sulawesi Utara, Tengah, Gorontalo Dan Maluku Utara', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (756, 27, '005012800307782000KD', 'PENGADILAN AGAMA TERNATE KELAS I B', 'general', 'Ternate', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Ternate', 'Kantor Wilayah DJKN Sulawesi Utara, Tengah, Gorontalo Dan Maluku Utara', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (757, 27, '005012800307796000KD', 'PENGADILAN AGAMA MOROTAI', 'general', 'Morotai', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Ternate', 'Kantor Wilayah DJKN Sulawesi Utara, Tengah, Gorontalo Dan Maluku Utara', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (758, 27, '005012800307801000KD', 'PENGADILAN AGAMA SOASIO', 'general', 'Soa Sio', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Ternate', 'Kantor Wilayah DJKN Sulawesi Utara, Tengah, Gorontalo Dan Maluku Utara', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (759, 27, '005012800307818000KD', 'PENGADILAN AGAMA LABUHA 01', 'general', 'Labuhan Bacan', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Ternate', 'Kantor Wilayah DJKN Sulawesi Utara, Tengah, Gorontalo Dan Maluku Utara', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (760, 27, '005012800440740000KD', 'PENGADILAN TINGGI AGAMA MALUT', 'tingkatbanding', 'Maluku Utara', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Ternate', 'Kantor Wilayah DJKN Sulawesi Utara, Tengah, Gorontalo Dan Maluku Utara', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (761, 27, '005012800664522000KD', 'PENGADILAN TINGGI MALUKU UTARA', 'tingkatbanding', 'Maluku Utara', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Ternate', 'Kantor Wilayah DJKN Sulawesi Utara, Tengah, Gorontalo Dan Maluku Utara', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (762, 28, '005012900097560000KD', 'PENGADILAN NEGERI SERANG', 'general', 'Serang', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Serang', 'Kantor Wilayah DJKN Banten', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (763, 28, '005012900097577000KD', 'PENGADILAN NEGERI RANGKASBITUNG', 'general', 'Rangkas Bitung', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Serang', 'Kantor Wilayah DJKN Banten', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (764, 28, '005012900097598000KD', 'PENGADILAN NEGERI TANGERANG', 'general', 'Tangerang', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Tangerang II', 'Kantor Wilayah DJKN Banten', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (765, 28, '005012900400797000KD', 'PENGADILAN AGAMA SERANG', 'general', 'Serang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Serang', 'Kantor Wilayah DJKN Banten', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (766, 28, '005012900400817000KD', 'PENGADILAN AGAMA RANGKASBITUNG', 'general', 'Rangkas Bitung', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Serang', 'Kantor Wilayah DJKN Banten', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (767, 28, '005012900400823000KD', 'PENGADILAN AGAMA TANGERANG', 'general', 'Tangerang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Tangerang II', 'Kantor Wilayah DJKN Banten', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (768, 28, '005012900417844000KD', 'PENGADILAN NEGERI PANDEGLANG', 'general', 'Pandeglang', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Serang', 'Kantor Wilayah DJKN Banten', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (769, 28, '005012900417850000KD', 'PENGADILAN AGAMA PANDEGLANG', 'general', 'Pandeglang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Serang', 'Kantor Wilayah DJKN Banten', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (770, 28, '005012900440712000KD', 'PENGADILAN TINGGI AGAMA BANTEN', 'tingkatbanding', 'Banten', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Serang', 'Kantor Wilayah DJKN Banten', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (771, 28, '005012900604723000KD', 'PENGADILAN AGAMA TIGARAKSA', 'general', 'Tigaraksa', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Tangerang II', 'Kantor Wilayah DJKN Banten', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (772, 28, '005012900652076000KD', 'PENGADILAN AGAMA CILEGON', 'general', 'Cilegon', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Serang', 'Kantor Wilayah DJKN Banten', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (773, 28, '005012900663398000KD', 'PENGADILAN TINGGI BANTEN', 'tingkatbanding', 'Banten', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Serang', 'Kantor Wilayah DJKN Banten', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (774, 28, '005012900689313000KD', 'PENGADILAN TATA USAHA NEGARA SERANG', 'general', 'Serang', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', 'Kantor Pelayanan Kekayaan Negara dan Lelang Serang', 'Kantor Wilayah DJKN Banten', 'PT', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (775, 29, '005013000099010000KD', 'PENGADILAN NEGERI PANGKALPINANG', 'general', 'Pangkal Pinang', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pangkalpinang', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (776, 29, '005013000099024000KD', 'PENGADILAN NEGERI SUNGAILIAT', 'general', 'Sungai Liat', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pangkalpinang', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (777, 29, '005013000402302000KD', 'PENGADILAN AGAMA PANGKALPINANG', 'general', 'Pangkal Pinang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pangkalpinang', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (778, 29, '005013000402318000KD', 'PENGADILAN AGAMA TANJUNGPANDAN', 'general', 'Tanjung Pandan', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pangkalpinang', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (779, 29, '005013000440728000KD', 'PENGADILAN TINGGI AGAMA KEPULAUAN BANGKA BELITUNG', 'tingkatbanding', 'Bangka Belitung', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pangkalpinang', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (780, 29, '005013000663403000KD', 'PENGADILAN TINGGI KEPULAUAN BANGKA BELITUNG', 'tingkatbanding', 'Bangka Belitung', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pangkalpinang', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (781, 29, '005013000682249000KD', 'PENGADILAN AGAMA MENTOK', 'general', 'Mentok', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pangkalpinang', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (782, 30, '005013100099361000KD', 'PENGADILAN NEGERI GORONTALO', 'general', 'Gorontalo', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Gorontalo', 'Kantor Wilayah DJKN Sulawesi Utara, Tengah, Gorontalo Dan Maluku Utara', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (783, 30, '005013100307250000KD', 'PENGADILAN AGAMA GORONTALO', 'general', 'Gorontalo', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Gorontalo', 'Kantor Wilayah DJKN Sulawesi Utara, Tengah, Gorontalo Dan Maluku Utara', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (784, 30, '005013100402690000KD', 'PENGADILAN AGAMA LIMBOTO', 'general', 'Limboto', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Gorontalo', 'Kantor Wilayah DJKN Sulawesi Utara, Tengah, Gorontalo Dan Maluku Utara', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (785, 30, '005013100440734000KD', 'PENGADILAN TINGGI AGAMA GORONTALO', 'tingkatbanding', 'Gorontalo', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Gorontalo', 'Kantor Wilayah DJKN Sulawesi Utara, Tengah, Gorontalo Dan Maluku Utara', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (786, 30, '005013100477218000KD', 'PENGADILAN NEGERI TILAMUTA', 'general', 'Tilamuta', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Gorontalo', 'Kantor Wilayah DJKN Sulawesi Utara, Tengah, Gorontalo Dan Maluku Utara', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (787, 30, '005013100652130000KD', 'PENGADILAN AGAMA TILAMUTA', 'general', 'Tilamuta', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Gorontalo', 'Kantor Wilayah DJKN Sulawesi Utara, Tengah, Gorontalo Dan Maluku Utara', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (788, 30, '005013100664539000KD', 'PENGADILAN TINGGI GORONTALO', 'tingkatbanding', 'Gorontalo', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Gorontalo', 'Kantor Wilayah DJKN Sulawesi Utara, Tengah, Gorontalo Dan Maluku Utara', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (789, 30, '005013100670184000KD', 'PENGADILAN NEGERI MARISA', 'general', 'Marisa', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Gorontalo', 'Kantor Wilayah DJKN Sulawesi Utara, Tengah, Gorontalo Dan Maluku Utara', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (790, 30, '005013100682185000KD', 'PENGADILAN AGAMA MARISA', 'general', 'Marisa', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Gorontalo', 'Kantor Wilayah DJKN Sulawesi Utara, Tengah, Gorontalo Dan Maluku Utara', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (791, 31, '005013200098881000KD', 'PN TANJUNGPINANG', 'general', 'Tanjung Pinang', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Batam', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (792, 31, '005013200108309000KD', 'PENGADILAN NEGERI BATAM', 'general', 'Batam', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Batam', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (793, 31, '005013200402148000KD', 'PA TANJUNGPINANG', 'general', 'Tanjung Pinang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Batam', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (794, 31, '005013200402154000KD', 'PENGADILAN AGAMA DABO SINGKEP', 'general', 'Dabo Singkep', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Batam', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (795, 31, '005013200402160000KD', 'PENGADILAN AGAMA TANJUNG BALAI KARIMUN', 'general', 'Tanjung Balai Karimun', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Batam', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (796, 31, '005013200402179000KD', 'PENGADILAN AGAMA TAREMPA', 'general', 'Tarempa', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Batam', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (797, 31, '005013200547699000KD', 'PENGADILAN AGAMA BATAM', 'general', 'Batam', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Batam', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (798, 31, '005013200614670000KD', 'PENGADILAN AGAMA NATUNA', 'general', 'Natuna', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Batam', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (799, 31, '005013200663005000KD', 'PENGADILAN NEGERI TANJUNG BALAI KARIMUN', 'general', 'Tanjung Balai Karimun', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Batam', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (800, 31, '005013200689309000KD', 'PENGADILAN TATA USAHA NEGARA TANJUNGPINANG', 'general', 'Tanjung Pinang', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', 'Kantor Pelayanan Kekayaan Negara dan Lelang Batam', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PT', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (801, 32, '005013300400075000KD', 'PENGADILAN NEGERI SORONG', 'general', 'Sorong', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Sorong', 'Kantor Wilayah DJKN Papua, Papua Barat Dan Maluku', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (802, 32, '005013300400081000KD', 'PENGADILAN NEGERI FAKFAK', 'general', 'Fak Fak', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Sorong', 'Kantor Wilayah DJKN Papua, Papua Barat Dan Maluku', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (803, 32, '005013300402882000KD', 'PENGADILAN AGAMA SORONG', 'general', 'Sorong', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Sorong', 'Kantor Wilayah DJKN Papua, Papua Barat Dan Maluku', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (804, 32, '005013300402902000KD', 'PENGADILAN AGAMA FAKFAK', 'general', 'Fak Fak', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Sorong', 'Kantor Wilayah DJKN Papua, Papua Barat Dan Maluku', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (805, 32, '005013300402911000KD', 'PENGADILAN AGAMA MANOKWARI', 'general', 'Manokwari', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Sorong', 'Kantor Wilayah DJKN Papua, Papua Barat Dan Maluku', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (806, 33, '005013400099621000KD', 'PENGADILAN NEGERI MAJENE', 'general', 'Majene', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Mamuju', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (807, 33, '005013400099642000KD', 'PENGADILAN NEGERI POLEWALI', 'general', 'Polewali', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Mamuju', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (808, 33, '005013400307630000KD', 'PENGADILAN AGAMA POLEWALI', 'general', 'Polewali', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Mamuju', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (809, 33, '005013400307644000KD', 'PENGADILAN AGAMA MAJENE', 'general', 'Majene', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Mamuju', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (810, 33, '005013400307651000KD', 'PENGADILAN AGAMA MAMUJU', 'general', 'Mamuju', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Mamuju', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (811, 33, '005013400681422000KD', 'PENGADILAN NEGERI PASANGKAYU', 'general', NULL, NULL, NULL, NULL, 'PN', NULL, '2018-12-05 19:50:08', '2021-03-13 12:48:07');
INSERT INTO `satkers` VALUES (812, 34, '005013500099272000KD', 'PENGADILAN NEGERI TARAKAN', 'general', 'Tarakan', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Tarakan', 'Kantor Wilayah DJKN Kalimantan Timur Dan Utara', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (813, 34, '005013500402675000KD', 'PENGADILAN AGAMA TARAKAN', 'general', 'Tarakan', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Tarakan', 'Kantor Wilayah DJKN Kalimantan Timur Dan Utara', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (814, 34, '005013500417657000KD', 'Pengadilan Agama Tanjung Selor', 'general', 'Tanjung Selor', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (815, 34, '005013500417704000KD', 'PENGADILAN NEGERI MALINAU', 'general', 'Malinau', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (816, 34, '005013500417722000KD', 'PENGADILAN NEGERI TANJUNG SELOR', 'general', 'Tanjung Selor', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (817, 34, '005013500477270000KD', 'Pengadilan Negeri Nunukan', 'general', 'Nunukan', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Tarakan', 'Kantor Wilayah DJKN Kalimantan Timur Dan Utara', 'PN', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (818, 34, '005013500682295000KD', 'PENGADILAN AGAMA NUNUKAN', 'general', 'Nunukan', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Tarakan', 'Kantor Wilayah DJKN Kalimantan Timur Dan Utara', 'PA', NULL, '2018-12-05 19:50:08', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (819, 25, '005012500402891000KD', 'PENGADILAN AGAMA BIAK', 'general', 'Biak', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Biak', 'Kantor Wilayah DJKN Papua, Papua Barat Dan Maluku', 'PA', NULL, '2018-12-06 00:04:08', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (820, 25, '005012500402933000KD', 'PENGADILAN AGAMA WAMENA', 'general', 'Wamena', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jayapura', 'Kantor Wilayah DJKN Papua, Papua Barat Dan Maluku', 'PA', NULL, '2018-12-06 00:04:08', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (821, 25, '005012500402942000KD', 'PENGADILAN AGAMA SERUI', 'general', 'Serui', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Biak', 'Kantor Wilayah DJKN Papua, Papua Barat Dan Maluku', 'PA', NULL, '2018-12-06 00:04:08', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (822, 25, '005012500402958000KD', 'PENGADILAN AGAMA MERAUKE', 'general', 'Merauke', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jayapura', 'Kantor Wilayah DJKN Papua, Papua Barat Dan Maluku', 'PA', NULL, '2018-12-06 00:04:08', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (823, 25, '005012500539138000KD', 'PENGADILAN TATA USAHA NEGARA JAYAPURA', 'general', 'Jayapura', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jayapura', 'Kantor Wilayah DJKN Papua, Papua Barat Dan Maluku', 'PT', NULL, '2018-12-06 00:04:08', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (824, 25, '005012500614769000KD', 'PENGADILAN AGAMA SENTANI', 'general', 'Sentani', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jayapura', 'Kantor Wilayah DJKN Papua, Papua Barat Dan Maluku', 'PA', NULL, '2018-12-06 00:04:08', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (825, 25, '005012500614773000KD', 'PENGADILAN AGAMA MIMIKA', 'general', 'Mimika', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jayapura', 'Kantor Wilayah DJKN Papua, Papua Barat Dan Maluku', 'PA', NULL, '2018-12-06 00:04:08', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (826, 25, '005012500614780000KD', 'PENGADILAN AGAMA PANIAI', 'general', 'Paniai', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Biak', 'Kantor Wilayah DJKN Papua, Papua Barat Dan Maluku', 'PA', NULL, '2018-12-06 00:04:08', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (827, 35, '005020199004028000KP', 'KEPANITERAAN', 'general', 'Jakarta', 'Kepaniteraan', NULL, NULL, NULL, NULL, '2019-07-22 12:05:37', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (828, 35, '005030199097450000KP', 'DITJEN BADAN PERADILAN UMUM', 'general', 'Jakarta', 'Badan Peradilan Umum', NULL, NULL, NULL, NULL, '2019-07-22 12:05:37', '2021-03-19 10:23:57');
INSERT INTO `satkers` VALUES (829, 5, '005030500099151000KD', 'PENGADILAN NEGERI BLITAR 03', 'general', 'Blitar', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2019-07-22 12:05:37', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (830, 5, '005030500099158000KD', 'PENGADILAN NEGERI KRAKSAAN', 'general', 'Kraksaan', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2019-07-22 12:05:37', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (831, 20, '005032000681440000KD', 'PENGADILAN NEGERI ANDOOLO', 'general', 'Andoolo', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kendari', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PN', NULL, '2019-07-22 12:05:37', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (832, 25, '005032500400045000KD', 'PENGADILAN NEGERI WAMENA (03)', 'general', 'Wamena', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2019-07-22 12:05:37', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (833, 35, '005040199663712000KP', 'DIREKTORAT JENDERAL BADAN PERADILAN AGAMA', 'general', 'Jakarta', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2019-07-22 12:05:37', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (834, 19, '005041900309076000KD', 'PENGADILAN AGAMA WATAMPONE', 'general', 'Watampone', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2019-07-22 12:05:37', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (835, 35, '005050199663122000KP', 'DIREKTORAT JENDERAL BADAN PERADILAN MILITER DAN TUN', 'general', 'Jakarta', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', NULL, NULL, NULL, NULL, '2019-07-22 12:05:37', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (836, 35, '005060199610378000KP', 'BADAN LITBANG DIKLAT KUMDIL MA RI', 'general', 'Jakarta', 'Badan Litbang Diklat Kumdil', NULL, NULL, NULL, NULL, '2019-07-22 12:05:37', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (837, 35, '005070199663136000KP', 'BADAN PENGAWASAN', 'general', 'Jakarta', 'Badan Pengawasan', NULL, NULL, NULL, NULL, '2019-07-22 12:05:37', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (838, 2, '005010200401914000KD', 'PENGADILAN NEGERI BANJAR', 'general', 'Banjar', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2019-08-13 16:10:17', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (839, 2, '005010200401957000KD', 'Pengadilan Agama Soreang (01)', 'general', 'Soreang', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2019-08-13 16:10:17', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (840, 2, '005010200401959000KD', 'Pengadilan Agama Ngamprah', 'general', 'Ngamprah', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2019-08-13 16:10:17', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (841, 6, '005010600401902000KD', 'PENGADILAN NEGERI BLANGPIDIE', 'general', 'Blangpidie', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2019-08-13 16:10:17', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (842, 6, '005010600401903000KD', 'Pengadilan Negeri Meureudu', 'general', 'Meureudu', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2019-08-13 16:10:17', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (843, 6, '005010600401904000KD', 'Pengadilan Negeri Suka Makmue', 'general', 'Suka Makmue', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2019-08-13 16:10:17', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (844, 6, '005010600401965000KD', 'Mahkamah Syariah Blangpidie', 'general', 'Blangpidie', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2019-08-13 16:10:17', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (845, 6, '005010600401966000KD', 'MAHKAMAH SYAR\'IYAH SUKA MAKMUE', 'general', 'Suka Makmue', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2019-08-13 16:10:17', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (846, 6, '005010600401967000KD', 'Mahkamah Syar\'iyah Kota Subulussalam', 'general', 'Kota Subulussalam', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2019-08-13 16:10:17', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (847, 7, '005010700401905000KD', 'PENGADILAN NEGERI SEI RAMPAH', 'general', 'Sei Rampah', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2019-08-13 16:10:17', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (848, 7, '005010700401906000KD', 'Pengadilan Negeri Sibuhuan', 'general', 'Sibuhuan', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2019-08-13 16:10:17', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (849, 8, '005010800401936000KD', 'PENGADILAN AGAMA PULAU PUNJUNG', 'general', 'Pulau Punjung', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2019-08-13 16:10:17', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (850, 9, '005010900401937000KD', 'PENGADILAN AGAMA SIAK SRI INDRAPURA (01)', 'general', 'Siak Sri Indrapura', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2019-08-13 16:10:17', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (851, 11, '005011100401909000KD', 'PENGADILAN NEGERI PANGKALAN BALAI', 'general', 'Pangkalan Balai', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2019-08-13 16:10:17', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (852, 11, '005011100401949000KD', 'PENGADILAN AGAMA PRABUMULIH', 'general', 'Prabumulih', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2019-08-13 16:10:17', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (853, 12, '005011200401950000KD', 'PENGADILAN AGAMA GEDONG TATAAN', 'general', 'Gedong Tataan', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2019-08-13 16:10:17', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (854, 12, '005011200401951000KD', 'PENGADILAN AGAMA PRINGSEWU', 'general', 'Pringsewu', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2019-08-13 16:10:17', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (855, 12, '005011200401952000KD', 'PENGADILAN AGAMA MESUJI 01', 'general', 'Mesuji', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2019-08-13 16:10:17', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (856, 12, '005011200401955000KD', 'PENGADILAN AGAMA TULANG BAWANG TENGAH 01', 'general', 'Tulang Bawang Tengah', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2019-08-13 16:10:17', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (857, 13, '005011300401960000KD', 'Pengadilan Agama Singkawang (01)', 'general', 'Singkawang', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2019-08-13 16:10:17', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (858, 13, '005011300401961000KD', 'Pengadilan Agama Nanga Pinoh', 'general', 'Nanga Pinoh', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2019-08-13 16:10:17', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (859, 13, '005011300401964000KD', 'Pengadilan Agama Sungai Raya (01)', 'general', 'Sungai Raya', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2019-08-13 16:10:17', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (860, 14, '005011400401868000KD', 'PENGADILAN AGAMA NANGA BULIK', 'general', 'Nanga Bulik', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2019-08-13 16:10:17', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (861, 14, '005011400401873000KD', 'Pengadilan Agama Kasongan', 'general', 'Kasongan', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2019-08-13 16:10:17', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (862, 14, '005011400401874000KD', 'Pengadilan Agama Tamiang Layang', 'general', 'Tamiyang Layang', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2019-08-13 16:10:17', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (863, 14, '005011400401875000KD', 'Pengadilan Agama Pulang Pisau', 'general', 'Pulang Pisau', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2019-08-13 16:10:17', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (864, 14, '005011400401876000KD', 'Pengadilan Agama Kuala Kurun Kelas II', 'general', 'Kuala Kurun', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2019-08-13 16:10:17', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (865, 14, '005011400401919000KD', 'PENGADILAN NEGERI NANGA BULIK KELAS II', 'general', 'Nanga Bulik', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2019-08-13 16:10:17', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (866, 14, '005011400401920000KD', 'Pengadilan Negeri Pulang Pisau', 'general', 'Pulang Pisau', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2019-08-13 16:10:17', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (867, 15, '005011500401921000KD', 'PENGADILAN NEGERI PARINGIN', 'general', 'Paringin', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2019-08-13 16:10:17', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (868, 16, '005011600401877000KD', 'PENGADILAN AGAMA PENAJAM', 'general', 'Penajam', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2019-08-13 16:10:17', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (869, 16, '005011600401878000KD', 'Pengadilan Agama Sendawar', 'general', 'Sendawar', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2019-08-13 16:10:17', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (870, 16, '005011600401924000KD', 'PENGADILAN NEGERI PENAJAM (01)', 'general', 'Penajam', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2019-08-13 16:10:17', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (871, 17, '005011700401888000KD', 'Pengadilan Agama Lolak', 'general', 'Lolak', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2019-08-13 16:10:17', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (872, 17, '005011700401889000KD', 'PENGADILAN AGAMA BOLAANG UKI', 'general', 'Bolaang Uki', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2019-08-13 16:10:17', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (873, 17, '005011700401890000KD', 'PENGADILAN AGAMA BOROKKO', 'general', 'Boroko', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2019-08-13 16:10:17', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (874, 17, '005011700401891000KD', 'PENGADILAN AGAMA TUTUYAN', 'general', 'Tutuyan', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2019-08-13 16:10:17', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (875, 19, '005011900401879000KD', 'PENGADILAN AGAMA BELOPA', 'general', 'Belopa', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2019-08-13 16:10:17', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (876, 19, '005011900401928000KD', 'PENGADILAN NEGERI BELOPA', 'general', 'Belopa', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2019-08-13 16:10:17', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (877, 20, '005012000401927000KD', 'PENGADILAN NEGERI WANGI WANGI KELAS II', 'general', 'Wangi Wangi', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2019-08-13 16:10:17', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (878, 21, '005012100401894000KD', 'PENGADILAN AGAMA DATARAN HUNIPOPU', 'general', 'Dataran Hunipopu', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2019-08-13 16:10:17', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (879, 21, '005012100401895000KD', 'Pengadilan Agama Dataran Hunimoa', 'general', 'Dataran Hunimoa', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2019-08-13 16:10:17', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (880, 21, '005012100401898000KD', 'PENGADILAN AGAMA NAMLEA', 'general', 'Namlea', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2019-08-13 16:10:17', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (881, 21, '005012100401929000KD', 'PENGADILAN NEGERI DOBO', 'general', 'Dobo', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2019-08-13 16:10:17', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (882, 21, '005012100401930000KD', 'PENGADILAN NEGERI NAMLEA', 'general', 'Namlea', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2019-08-13 16:10:17', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (883, 21, '005012100401970000KD', 'PENGADILAN NEGERI DATARAN HUNIPOPU', 'general', 'Dataran Hunipopu', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2019-08-13 16:10:17', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (884, 21, '005012100401971000KD', 'PENGADILAN NEGERI DATARAN HUNIMOA', 'general', 'Dataran Hunimoa', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2019-08-13 16:10:17', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (885, 26, '005012600401910000KD', 'PENGADILAN NEGERI MUKOMUKO', 'general', 'Mukomuko', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2019-08-13 16:10:17', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (886, 26, '005012600401939000KD', 'Pengadilan Agama Mukomuko', 'general', 'Mukomuko', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2019-08-13 16:10:17', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (887, 26, '005012600401940000KD', 'PENGADILAN AGAMA BINTUHAN', 'general', 'Bintuhan', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2019-08-13 16:10:17', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (888, 26, '005012600401941000KD', 'PENGADILAN AGAMA TAIS', 'general', 'Tais', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2019-08-13 16:10:17', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (889, 26, '005012600401942000KD', 'PENGADILAN AGAMA KEPAHIANG (01)', 'general', 'Kepahiang', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2019-08-13 16:10:18', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (890, 29, '005013000401912000KD', 'PENGADILAN NEGERI KOBA', 'general', 'Koba', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2019-08-13 16:10:18', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (891, 29, '005013000401913000KD', 'PENGADILAN NEGERI MENTOK', 'general', 'Mentok', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2019-08-13 16:10:18', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (892, 29, '005013000401968000KD', 'PENGADILAN TATA USAHA NEGARA PANGKALPINANG', 'general', 'Pangkal Pinang', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', NULL, NULL, 'PT', NULL, '2019-08-13 16:10:18', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (893, 30, '005013100401892000KD', 'PENGADILAN AGAMA SUWAWA', 'general', 'Suwawa', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2019-08-13 16:10:18', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (894, 30, '005013100401893000KD', 'PENGADILAN AGAMA KWANDANG', 'general', 'Kwandang', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2019-08-13 16:10:18', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (895, 33, '005013400401882000KD', 'PENGADILAN AGAMA PASANGKAYU', 'general', 'Pasangkayu', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2019-08-13 16:10:18', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (896, 14, '005011400401918000KD', 'PENGADILAN NEGERI KUALA KURUN KELAS II', 'general', 'Kuala Kurun', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2019-11-07 18:16:34', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (897, 17, '005011700401925000KD', 'PENGADILAN NEGERI MELONGUANE', 'general', 'Melonguane', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2019-11-07 18:16:34', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (898, 2, '005010200401915000KD', 'Pengadilan Negeri Cikarang', 'general', 'Cikarang', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-01-08 11:26:52', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (899, 7, '005010700401934000KD', 'Pengadilan Agama Sibuhuan', 'general', 'Sibuhuan', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-01-08 11:26:52', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (900, 9, '005010900401908000KD', 'PENGADILAN NEGERI TELUK KUANTAN', 'general', 'Teluk Kuantan', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-01-08 11:26:52', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (901, 16, '005011600682295000KD', 'PENGADILAN AGAMA NUNUKAN', 'general', NULL, NULL, NULL, NULL, 'PA', NULL, '2020-01-08 11:26:52', '2021-03-13 12:37:04');
INSERT INTO `satkers` VALUES (902, 18, '005011800401884000KD', 'PENGADILAN AGAMA AMPANA', 'general', 'Ampana', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-01-08 11:26:52', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (903, 20, '005012000401926000KD', 'PENGADILAN NEGERI LASUSUA', 'general', 'Lasusua', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-01-08 11:26:52', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (904, 7, '005010700401935000KD', 'PENGADILAN AGAMA SEI RAMPAH (01)', 'general', 'Sei Rampah', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-01-08 11:27:12', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (905, 8, '005010800401907000KD', 'PENGADILAN NEGERI PULAU PUNJUNG (01)', 'general', 'Pulau Punjung', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-01-08 11:27:12', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (906, 9, '005010900401938000KD', 'PENGADILAN AGAMA TELUK KUANTAN', 'general', 'Teluk Kuantan', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-01-08 11:27:12', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (907, 12, '005011200401911000KD', 'PENGADILAN NEGERI GEDONG TATAAN', 'general', 'Gedong Tataan', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-01-08 11:27:12', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (908, 14, '005011400401869000KD', 'PENGADILAN AGAMA SUKAMARA', 'general', 'Sukamara', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-01-08 11:27:12', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (909, 14, '005011400401870000KD', 'PENGADILAN AGAMA KUALA PEMBUANG', 'general', 'Kuala Pembuang', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-01-08 11:27:12', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (910, 20, '005012000401885000KD', 'PENGADILAN AGAMA WANGI WANGI (01)', 'general', 'Wangi Wangi', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-01-08 11:27:12', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (911, 20, '005012000401886000KD', 'PENGADILAN AGAMA LASUSUA (01)', 'general', 'Lasusua', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-01-08 11:27:12', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (912, 20, '005012000401887000KD', 'PENGADILAN AGAMA RUMBIA (01)', 'general', 'Rumbia', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-01-08 11:27:12', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (913, 11, '005011100401945000KD', 'PENGADILAN AGAMA MUARADUA', 'general', 'Muaradua', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-07-09 13:13:49', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (914, 12, '005011200401956000KD', 'PENGADILAN AGAMA SUKADANA ', 'general', 'Sukadana', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-07-09 13:13:49', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (915, 19, '005011900401883000KD', 'PENGADILAN AGAMA MALILI', 'general', 'Malili', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-07-09 13:13:49', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (916, 27, '005012800401972000KD', 'Pengadilan Negeri Sanana', 'general', 'Sanana', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-07-09 13:13:50', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (917, 27, '005012800401973000KD', 'Pengadilan Negeri Bobong (1)', 'general', 'Bobong', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-07-09 13:13:50', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (918, 28, '005012900097581000KD', 'PENGADILAN NEGERI PANDEGLANG', 'general', NULL, NULL, NULL, NULL, 'PN', NULL, '2020-07-09 13:13:50', '2021-03-13 12:48:07');
INSERT INTO `satkers` VALUES (919, 32, '005013300401899000KD', 'PENGADILAN AGAMA KAIMANA 01', 'general', 'Kaimana', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-07-09 13:13:50', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (920, 32, '005013300401933000KD', 'PENGADILAN NEGERI KAIMANA', 'general', 'Kaimana', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-07-09 13:13:50', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (921, 2, '005010200401958000KD', 'Pengadilan Agama Kota Cimahi', 'general', 'Kota Cimahi', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:01:46', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (922, 11, '005011100401943000KD', 'Pengadilan Agama Pangkalan Balai', 'general', 'Pangkalan Balai', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:01:46', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (923, 11, '005011100401944000KD', 'PENGADILAN AGAMA MARTAPURA', 'general', 'Martapura', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:01:46', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (924, 11, '005011100401946000KD', 'PENGADILAN AGAMA PAGAR ALAM', 'general', 'Pagar Alam', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:01:46', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (925, 30, '005013100401969000KD', 'PENGADILAN TATA USAHA NEGARA GORONTALO', 'general', 'Gorontalo', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', NULL, NULL, 'PT', NULL, '2020-12-23 12:01:46', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (926, 1, '005030100099062000KD', 'PENGADILAN TINGGI JAKARTA (03)', 'tingkatbanding', 'Jakarta Pusat', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:56', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (927, 1, '005030100099063000KD', 'PENGADILAN NEGERI JAKARTA PUSAT', 'general', 'Jakarta Pusat', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:56', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (928, 1, '005030100099064000KD', 'PENGADILAN NEGERI JAKARTA BARAT (03)', 'general', 'Jakarta Barat', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:56', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (929, 1, '005030100099065000KD', 'PENGADILAN NEGERI JAKARTA TIMUR (03)', 'general', 'Jakarta Timur', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:56', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (930, 1, '005030100400215000KD', 'PENGADILAN NEGERI JAKARTA SELATAN (03)', 'general', 'Jakarta Selatan', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jakarta I', 'Kantor Wilayah DJKN DKI Jakarta', 'PN', NULL, '2020-12-23 12:02:56', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (931, 1, '005030100400221000KD', 'PENGADILAN NEGERI JAKARTA UTARA (03)', 'general', 'Jakarta Utara', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jakarta I', 'Kantor Wilayah DJKN DKI Jakarta', 'PN', NULL, '2020-12-23 12:02:56', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (932, 2, '005030200099067000KD', 'PENGADILAN TINGGI BANDUNG (03)', 'tingkatbanding', 'Bandung', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:56', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (933, 2, '005030200099068000KD', 'PENGADILAN NEGERI BANDUNG (03)', 'general', 'Bandung', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:56', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (934, 2, '005030200099069000KD', 'PENGADILAN NEGERI SUMEDANG', 'general', 'Sumedang', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:56', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (935, 2, '005030200099071000KD', 'PENGADILAN NEGERI TASIKMALAYA', 'general', 'Tasikmalaya', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:56', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (936, 2, '005030200099072000KD', 'PENGADILAN NEGERI GARUT', 'general', 'Garut', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:56', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (937, 2, '005030200099073000KD', 'PENGADILAN NEGERI CIAMIS KELAS IB', 'general', 'Ciamis', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:56', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (938, 2, '005030200099078000KD', 'PENGADILAN NEGERI  PURWAKARTA', 'general', 'Purwakarta', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:56', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (939, 2, '005030200099079000KD', 'PENGADILAN NEGERI BEKASI[03]', 'general', 'Bekasi', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:56', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (940, 2, '005030200099080000KD', 'PENGADILAN NEGERI  KARAWANG', 'general', 'Karawang', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:56', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (941, 2, '005030200099083000KD', 'PENGADILAN NEGERI SUKABUMI (BADILUM)', 'general', 'Sukabumi', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:56', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (942, 2, '005030200099084000KD', 'PENGADILAN NEGERI CIANJUR', 'general', 'Cianjur', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:56', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (943, 2, '005030200099085000KD', 'PENGADILAN NEGERI CIREBON', 'general', 'Cirebon', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:56', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (944, 2, '005030200099086000KD', 'PENGADILAN NEGERI INDRAMAYU', 'general', 'Indramayu', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:56', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (945, 2, '005030200099088000KD', 'PENGADILAN NEGERI MAJALENGKA', 'general', 'Majalengka', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:56', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (946, 2, '005030200099089000KD', 'PENGADILAN NEGERI KUNINGAN', 'general', 'Kuningan', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:56', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (947, 2, '005030200400410000KD', 'PENGADILAN NEGERI CIBADAK', 'general', 'Cibadak', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bogor', 'Kantor Wilayah DJKN Jawa Barat', 'PN', NULL, '2020-12-23 12:02:56', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (948, 2, '005030200400478000KD', 'PENGADILAN NEGERI SUMBER', 'general', 'Sumber', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Cirebon', 'Kantor Wilayah DJKN Jawa Barat', 'PN', NULL, '2020-12-23 12:02:56', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (949, 2, '005030200400484000KD', 'PENGADILAN NEGERI KELAS 1A BALE BANDUNG (03)', 'general', 'Bale Bandung', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bandung', 'Kantor Wilayah DJKN Jawa Barat', 'PN', NULL, '2020-12-23 12:02:56', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (950, 2, '005030200477293000KD', 'PENGADILAN NEGERI DEPOK', 'general', 'Depok', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bogor', 'Kantor Wilayah DJKN Jawa Barat', 'PN', NULL, '2020-12-23 12:02:56', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (951, 2, '005030200613520000KD', 'PENGADILAN NEGERI CIBINONG', 'general', 'Cibinong', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:56', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (952, 3, '005030300099090000KD', 'PENGADILAN TINGGI JAWA TENGAH ', 'tingkatbanding', 'Semarang', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:56', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (953, 3, '005030300099092000KD', 'PENGADILAN NEGERI SEMARANG', 'general', 'Semarang', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:56', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (954, 3, '005030300099093000KD', 'PENGADILAN NEGERI TEGAL', 'general', 'Tegal', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:56', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (955, 3, '005030300099094000KD', 'PENGADILAN NEGERI PEKALONGAN', 'general', 'Pekalongan', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:56', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (956, 3, '005030300099095000KD', 'PENGADILAN NEGERI KUDUS', 'general', 'Kudus', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:56', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (957, 3, '005030300099096000KD', 'PENGADILAN NEGERI PATI', 'general', 'Pati', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:56', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (958, 3, '005030300099097000KD', 'PN BREBES 03', 'general', 'Brebes', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:56', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (959, 3, '005030300099098000KD', 'PENGADILAN NEGERI PEMALANG', 'general', 'Pemalang', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:56', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (960, 3, '005030300099099000KD', 'PENGADILAN NEGERI KENDAL (03)', 'general', 'Kendal', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:56', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (961, 3, '005030300099100000KD', 'PENGADILAN NEGERI DEMAK', 'general', 'Demak', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:56', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (962, 3, '005030300099102000KD', 'PENGADILAN NEGERI SALATIGA', 'general', 'Salatiga', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:56', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (963, 3, '005030300099103000KD', 'PENGADILAN NEGERI UNGARAN', 'general', 'Ungaran', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:56', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (964, 3, '005030300099104000KD', 'PN JEPARA', 'general', 'Jepara', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:56', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (965, 3, '005030300099105000KD', 'PENGADILAN NEGERI BLORA', 'general', 'Blora', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:56', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (966, 3, '005030300099106000KD', 'PENGADILAN NEGERI REMBANG', 'general', 'Rembang', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:56', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (967, 3, '005030300099107000KD', 'PENGADILAN NEGERI BATANG', 'general', 'Batang', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:56', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (968, 3, '005030300099108000KD', 'PENGADILAN NEGERI PURWOREJO', 'general', 'Purworejo', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:56', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (969, 3, '005030300099110000KD', 'PENGADILAN NEGERI MAGELANG', 'general', 'Magelang', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:56', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (970, 3, '005030300099112000KD', 'Pengadilan Negeri Temanggung (03)', 'general', 'Temanggung', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:56', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (971, 3, '005030300099114000KD', 'PENGADILAN NEGERI WONOSOBO', 'general', 'Wonosobo', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:56', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (972, 3, '005030300099115000KD', 'PENGADILAN NEGERI SURAKARTA', 'general', 'Surakarta', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:56', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (973, 3, '005030300099116000KD', 'PENGADILAN NEGERI SRAGEN KELAS I A', 'general', 'Sragen', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:56', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (974, 3, '005030300099117000KD', 'PENGADILAN NEGERI WONOGIRI', 'general', 'Wonogiri', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:56', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (975, 3, '005030300099118000KD', 'PENGADILAN NEGERI SUKOHARJO', 'general', 'Sukoharjo', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:56', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (976, 3, '005030300099119000KD', 'PENGADILAN NEGERI KARANGANYAR', 'general', 'Karangayar', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:56', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (977, 3, '005030300099121000KD', 'PENGADILAN NEGERI BOYOLALI', 'general', 'Boyolali', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:56', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (978, 3, '005030300099122000KD', 'PENGADILAN NEGERI KLATEN', 'general', 'Klaten', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:56', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (979, 3, '005030300099123000KD', 'PENGADILAN NEGERI PURWOKERTO', 'general', 'Purwokerto', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:56', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (980, 3, '005030300099124000KD', 'PENGADILAN NEGERI CILACAP', 'general', 'Cilacap', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:56', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (981, 3, '005030300099125000KD', 'PENGADILAN NEGERI BANYUMAS', 'general', 'Banyumas', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (982, 3, '005030300099126000KD', 'PENGADILAN NEGERI PURBALINGGA', 'general', 'Purbalingga', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (983, 3, '005030300099127000KD', 'PENGADILAN NEGERI BANJARNEGARA', 'general', 'Banjarnegara', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (984, 3, '005030300400566000KD', 'PENGADILAN NEGERI SLAWI', 'general', 'Tegal', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Tegal', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (985, 3, '005030300400572000KD', 'PENGADILAN NEGERI MUNGKID', 'general', 'Kabupaten Magelang Di Mungkid', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Semarang', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (986, 4, '005030400099128000KD', 'PENGADILAN NEGERI YOGYAKARTA', 'general', 'Yogyakarta', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (987, 4, '005030400099129000KD', 'PENGADILAN NEGERI WATES', 'general', 'Wates', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (988, 4, '005030400099130000KD', 'PENGADILAN NEGERI WONOSARI', 'general', 'Wonosari', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (989, 4, '005030400400173000KD', 'PENGADILAN NEGERI BANTUL (BADILUM)', 'general', 'Bantul', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (990, 4, '005030400400343000KD', 'PENGADILAN TINGGI YOGYAKARTA', 'tingkatbanding', 'Yogyakarta', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (991, 5, '005030500099132000KD', 'PT SURABAYA 03', 'general', 'Surabaya', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (992, 5, '005030500099133000KD', 'PN SURABAYA', 'general', 'Surabaya', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (993, 5, '005030500099135000KD', 'PENGADILAN NEGERI BOJONEGORO 03', 'general', 'Bojonegoro', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (994, 5, '005030500099137000KD', 'PN LAMONGAN_03', 'general', 'Lamongan', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (995, 5, '005030500099138000KD', 'PN.GRESIK', 'general', 'Gresik', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (996, 5, '005030500099139000KD', 'PENGADILAN NEGERI SIDOARJO', 'general', 'Sidoarjo', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (997, 5, '005030500099142000KD', 'PENGADILAN NEGERI JOMBANG', 'general', 'Jombang', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (998, 5, '005030500099143000KD', 'PENGADILAN NEGERI BONDOWOSO', 'general', 'Bondowoso', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (999, 5, '005030500099145000KD', 'PENGADILAN NEGERI BANYUWANGI', 'general', 'Banyuwangi', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1000, 5, '005030500099147000KD', 'PENGADILAN NEGERI KEDIRI', 'general', 'Kediri', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1001, 5, '005030500099148000KD', 'PN NGANJUK', 'general', 'Nganjuk', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1002, 5, '005030500099149000KD', 'PENGADILAN NEGERI TULUNGAGUNG', 'general', 'Tulungagung', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1003, 5, '005030500099150000KD', 'Pengadilan Negeri Trenggalek', 'general', 'Trenggalek', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1004, 5, '005030500099152000KD', 'PENGADILAN NEGERI MALANG (03)', 'general', 'Malang', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1005, 5, '005030500099156000KD', 'PENGADILAN NEGERI LUMAJANG', 'general', 'Lumajang', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1006, 5, '005030500099157000KD', 'PN BANGIL', 'general', 'Bangil', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1007, 5, '005030500099160000KD', 'PENGADILAN NEGERI PONOROGO', 'general', 'Ponorogo', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1008, 5, '005030500099163000KD', 'PENGADILAN NEGERI NGAWI', 'general', 'Ngawi', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1009, 5, '005030500099164000KD', 'PENGADILAN NEGERI MAGETAN', 'general', 'Magetan', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1010, 5, '005030500099165000KD', 'PENGADILAN NEGERI KELAS IB PAMEKASAN', 'general', 'Pamekasan', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1011, 5, '005030500099167000KD', 'PENGADILAN NEGERI BANGKALAN', 'general', 'Bangkalan', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1012, 5, '005030500400581000KD', 'PENGADILAN NEGERI KABUPATEN  KEDIRI', 'general', 'Kab. Kediri', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1013, 5, '005030500626157000KD', 'PENGADILAN NEGERI KEPANJEN KABUPATEN MALANG', 'general', 'Kab.Malang, Jawa Timur', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Malang', 'Kantor Wilayah DJKN Jawa Timur', 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1014, 6, '005030600099169000KD', 'PENGADILAN TINGGI BANDA ACEH', 'tingkatbanding', 'Banda Aceh', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banda Aceh', 'Kantor Wilayah DJKN Aceh', 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1015, 6, '005030600099172000KD', 'PENGADILAN NEGERI SIGLI', 'general', 'Sigli', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banda Aceh', 'Kantor Wilayah DJKN Aceh', 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1016, 6, '005030600099174000KD', 'PENGADILAN NEGERI LHOKSUKON 03', 'general', 'Lhok Sukon', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Lhokseumawe', 'Kantor Wilayah DJKN Aceh', 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1017, 6, '005030600099175000KD', 'PENGADILAN NEGERI LHOKSEUMAWE', 'general', 'Lhok Seumawe', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Lhokseumawe', 'Kantor Wilayah DJKN Aceh', 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1018, 6, '005030600099178000KD', 'PENGADILAN NEGERI LANGSA', 'general', 'Langsa', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Lhokseumawe', 'Kantor Wilayah DJKN Aceh', 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1019, 6, '005030600099181000KD', 'PENGADILAN NEGERI KUALASIMPANG', 'general', 'Kuala Simpang', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Lhokseumawe', 'Kantor Wilayah DJKN Aceh', 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1020, 6, '005030600099185000KD', 'PENGADILAN NEGERI CALANG', 'general', 'Calang', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banda Aceh', 'Kantor Wilayah DJKN Aceh', 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1021, 6, '005030600099186000KD', 'PENGADILAN NEGERI SINABANG', 'general', 'Sinabang', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banda Aceh', 'Kantor Wilayah DJKN Aceh', 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1022, 6, '005030600400416000KD', 'PENGADILAN NEGERI JANTHO', 'general', 'Janthoi', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banda Aceh', 'Kantor Wilayah DJKN Aceh', 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1023, 7, '005030700099189000KD', 'PENGADILAN TINGGI MEDAN', 'tingkatbanding', 'Medan', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Medan', 'Kantor Wilayah DJKN Sumatera Utara', 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1024, 7, '005030700099191000KD', 'PENGADILAN NEGERI BINJAI', 'general', 'Binjai', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Medan', 'Kantor Wilayah DJKN Sumatera Utara', 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1025, 7, '005030700099192000KD', 'PENGADILAN NEGERI TANJUNGBALAI', 'general', 'Tanjung Balai Asahan', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kisaran', 'Kantor Wilayah DJKN Sumatera Utara', 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1026, 7, '005030700099193000KD', 'PENGADILAN NEGERI SIDIKALANG', 'general', 'Sidikalang', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pematang Siantar', 'Kantor Wilayah DJKN Sumatera Utara', 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1027, 7, '005030700099194000KD', 'PENGADILAN NEGERI KABANJAHE', 'general', 'Kabanjahe', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Medan', 'Kantor Wilayah DJKN Sumatera Utara', 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1028, 7, '005030700099195000KD', 'PENGADILAN NEGERI RANTAUPRAPAT', 'general', 'Rantau Prapat', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kisaran', 'Kantor Wilayah DJKN Sumatera Utara', 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1029, 7, '005030700099196000KD', 'PENGADILAN NEGERI TEBING TINGGI', 'tingkatbanding', 'Tebing Tinggi', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pematang Siantar', 'Kantor Wilayah DJKN Sumatera Utara', 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1030, 7, '005030700099198000KD', 'PENGADILAN NEGERI GUNUNGSITOLI', 'general', 'Gunung Sitoli', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Padangsidimpuan', 'Kantor Wilayah DJKN Sumatera Utara', 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1031, 7, '005030700099199000KD', 'PENGADILAN NEGERI PEMATANG SIANTAR', 'general', 'Pematang Siantar', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pematang Siantar', 'Kantor Wilayah DJKN Sumatera Utara', 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1032, 7, '005030700099200000KD', 'PENGADILAN NEGERI TARUTUNG', 'general', 'Tarutung', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Padangsidimpuan', 'Kantor Wilayah DJKN Sumatera Utara', 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1033, 7, '005030700099201000KD', 'PENGADILAN NEGERI PADANGSIDIMPUAN', 'general', 'Padang Sidempuan', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Padangsidimpuan', 'Kantor Wilayah DJKN Sumatera Utara', 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1034, 7, '005030700109063000KD', 'PENGADILAN NEGERI STABAT', 'general', 'Stabat', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Medan', 'Kantor Wilayah DJKN Sumatera Utara', 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1035, 7, '005030700400371000KD', 'PENGADILAN NEGERI SIMALUNGUN', 'general', 'Simalungun', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pematang Siantar', 'Kantor Wilayah DJKN Sumatera Utara', 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1036, 7, '005030700400396000KD', 'PENGADILAN NEGERI KLAS I-B LUBUK PAKAM.', 'general', 'Lubuk Pakam', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Medan', 'Kantor Wilayah DJKN Sumatera Utara', 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1037, 7, '005030700477401000KD', 'PENGADILAN NEGERI MANDAILING NATAL', 'general', 'Mandailing Natal', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Padangsidimpuan', 'Kantor Wilayah DJKN Sumatera Utara', 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1038, 7, '005030700672911000KD', 'PENGADILAN NEGERI BALIGE', 'general', 'Balige', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pematang Siantar', 'Kantor Wilayah DJKN Sumatera Utara', 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (1039, 8, '005030800099204000KD', 'PENGADILAN TINGGI PADANG', 'tingkatbanding', 'Padang', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1040, 8, '005030800099205000KD', 'PENGADILAN NEGERI KLAS I A PADANG', 'general', 'Padang', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1041, 8, '005030800099206000KD', 'PENGADILAN NEGERI SAWAHLUNTO (BADILUM)', 'general', 'Sawahlunto', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Padang', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1042, 8, '005030800099207000KD', 'PENGADILAN NEGERI BATUSANGKAR BADILUM', 'general', 'Batusangkar', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bukittinggi', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1043, 8, '005030800099208000KD', 'PENGADILAN NEGERI SOLOK', 'general', 'Solok', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Padang', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1044, 8, '005030800099209000KD', 'PENGADILAN NEGERI PARIAMAN', 'general', 'Pariaman', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Padang', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1045, 8, '005030800099210000KD', 'PENGADILAN NEGERI PAINAN', 'general', 'Painan', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Padang', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1046, 8, '005030800099211000KD', 'PENGADILAN NEGERI BUKITTINGGI', 'tingkatbanding', 'Bukittinggi', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bukittinggi', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1047, 8, '005030800099212000KD', 'PN LUBUK SIKAPING', 'general', 'Lubuk Sikaping', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bukittinggi', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1048, 8, '005030800099213000KD', 'PENGADILAN NEGERI PAYAKUMBUH', 'general', 'Payakumbuh', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bukittinggi', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1049, 8, '005030800400189000KD', 'PN PADANG PANJANG 03', 'general', 'Padang Panjang', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bukittinggi', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1050, 8, '005030800400334000KD', 'PN LUBUK BASUNG 03', 'general', 'Lubuk Basung', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bukittinggi', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1051, 8, '005030800400422000KD', 'PENGADILAN NEGERI TANJUNG PATI (03)', 'general', 'Tanjung Pati', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bukittinggi', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1052, 8, '005030800400447000KD', 'PENGADILAN NEGERI KOTOBARU', 'general', 'Kotobaru', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Padang', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1053, 8, '005030800400462000KD', 'PENGADILAN NEGERI MUARO (BADILUM)', 'general', 'Muaro', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Padang', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1054, 8, '005030800477353000KD', 'PENGADILAN NEGERII PASAMAN BARAT', 'general', 'Pasaman Barat', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bukittinggi', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1055, 9, '005030900099214000KD', 'PENGADILAN NEGERI PEKANBARU', 'general', 'Pekanbaru', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1056, 9, '005030900099215000KD', 'PENGADILAN NEGERI BENGKALIS', 'general', 'Bengkalis', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Dumai', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1057, 9, '005030900099216000KD', 'PENGADILAN NEGERI RENGAT', 'general', 'Rengat', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1058, 9, '005030900099217000KD', 'PENGADILAN NEGERI TEMBILAHAN', 'general', 'Tembilahan', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1059, 9, '005030900400142000KD', 'PENGADILAN NEGERI BANGKINANG', 'general', 'Bangkinang', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pekanbaru', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1060, 9, '005030900400328000KD', 'PENGADILAN NEGERI DUMAI', 'general', 'Dumai', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Dumai', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1061, 9, '005030900400493000KD', 'PENGADILAN TINGGI PEKANBARU', 'tingkatbanding', 'Pekanbaru', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pekanbaru', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1062, 9, '005030900477256000KD', 'PENGADILAN NEGERI PELALAWAN', 'general', 'Pelalawan', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pekanbaru', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1063, 9, '005030900477344000KD', 'PENGADILAN NEGERI SIAK SRI INDRAPURA', 'general', 'Siak Sri Indrapura', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Dumai', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1064, 9, '005030900662991000KD', 'PENGADILAN NEGERI PASIR PENGARAIAN', 'general', 'Pasir Pangaraian', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pekanbaru', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (1065, 10, '005031000099220000KD', 'PENGADILAN NEGERI JAMBI', 'general', 'Jambi', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1066, 10, '005031000099221000KD', 'PENGADILAN NEGERI MUARA BUNGO 03', 'general', 'Muara Bungo', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1067, 10, '005031000099222000KD', 'PENGADILAN NEGERI KUALA TUNGKAL', 'general', 'Kuala Tungkal', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1068, 10, '005031000099224000KD', 'PENGADILAN NEGERI SUNGAI PENUH', 'general', 'Sungai Penuh', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1069, 10, '005031000400312000KD', 'PENGADILAN NEGERI BANGKO', 'general', 'Bangko', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jambi', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1070, 10, '005031000400431000KD', 'PENGADILAN NEGERI MUARA BULIAN', 'general', 'Muara Bulian', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jambi', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1071, 10, '005031000400504000KD', 'PENGADILAN TINGGI JAMBI', 'tingkatbanding', 'Jambi', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jambi', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1072, 10, '005031000477369000KD', 'PENGADILAN NEGERI TEBO', 'general', 'Tebo', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jambi', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1073, 10, '005031000477375000KD', 'PENGADILAN NEGERI SAROLANGUN', 'general', 'Sarolangun', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jambi', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1074, 10, '005031000477402000KD', 'PENGADILAN NEGERI TANJUNG JABUNG TIMUR', 'general', 'Tanjung Jabung Timur', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jambi', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1075, 10, '005031000663013000KD', 'PENGADILAN NEGERI SENGETI', 'general', 'Sengeti', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jambi', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (1076, 11, '005031100099225000KD', 'PENGADILAN TINGGI PALEMBANG', 'tingkatbanding', 'Palembang', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1077, 11, '005031100099226000KD', 'PENGADILAN NEGERI PALEMBANG', 'general', 'Palembang', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1078, 11, '005031100099227000KD', 'PENGADILAN NEGERI KAYUAGUNG', 'general', 'Kayu Agung', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1079, 11, '005031100099228000KD', 'PENGADILAN NEGERI BATURAJA', 'general', 'Baturaja', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1080, 11, '005031100099229000KD', 'PENGADILAN NEGERI LUBUKLINGGAU', 'general', 'Lubuk Linggau', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1081, 11, '005031100099231000KD', 'PENGADILAN NEGERI LAHAT (03)', 'general', 'Lahat', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1082, 11, '005031100099232000KD', 'PENGADILAN NEGERI MUARA ENIM', 'general', 'Muara Enim', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1083, 11, '005031100099233000KD', 'PENGADILAN NEGERI SEKAYU', 'general', 'Sekayu', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1084, 11, '005031100672953000KD', 'PENGADILAN NEGERI PRABUMULIH', 'general', 'Prabumulih', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Palembang', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (1085, 12, '005031200099236000KD', 'PN TANJUNGKARANG', 'general', 'Tanjung Karang', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1086, 12, '005031200099237000KD', 'PENGADILAN NEGERI METRO', 'general', 'Metro', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1087, 12, '005031200099238000KD', 'PENGADILAN NEGERI KOTABUMI', 'general', 'Kotabumi', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1088, 12, '005031200400365000KD', 'PT TANJUNG KARANG', 'general', 'Tanjung Karang', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bandar Lampung', 'Kantor Wilayah DJKN Lampung Dan Bengkulu', 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1089, 12, '005031200400453000KD', 'PN KALIANDA', 'general', 'Kalianda', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1090, 12, '005031200477307000KD', 'PENGADILAN NEGERI KOTA AGUNG', 'general', 'Kota Agung', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bandar Lampung', 'Kantor Wilayah DJKN Lampung Dan Bengkulu', 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1091, 12, '005031200614884000KD', 'PN LIWA', 'general', 'Liwa Kabupaten Lampung Barat', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bandar Lampung', 'Kantor Wilayah DJKN Lampung Dan Bengkulu', 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1092, 12, '005031200663027000KD', 'PENGADILAN NEGERI MENGGALA', 'general', 'Menggala', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Metro', 'Kantor Wilayah DJKN Lampung Dan Bengkulu', 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (1093, 12, '005031200663048000KD', 'PENGADILAN NEGERI SUKADANA', 'general', 'Sukadana', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Metro', 'Kantor Wilayah DJKN Lampung Dan Bengkulu', 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (1094, 12, '005031200663052000KD', 'PN. BLAMBANGAN UMPU', 'general', 'Blambangan Umpu', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Metro', 'Kantor Wilayah DJKN Lampung Dan Bengkulu', 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (1095, 13, '005031300099239000KD', 'Pengadilan Negeri Pontianak', 'general', 'Pontianak', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1096, 13, '005031300099240000KD', 'PENGADILAN NEGERI SINGKAWANG (03)', 'general', 'Singkawang', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1097, 13, '005031300099245000KD', 'PENGADILAN NEGERI SANGGAU', 'general', 'Sanggau', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1098, 13, '005031300400195000KD', 'PN PUTUSSIBAU', 'general', 'Putussibau', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1099, 13, '005031300400252000KD', 'PENGADILAN TINGGI PONTIANAK (03)', 'tingkatbanding', 'Pontianak', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1100, 13, '005031300670228000KD', 'PENGADILAN NEGERI SAMBAS (03)', 'general', 'Sambas', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Singkawang', 'Kantor Wilayah DJKN Kalimantan Barat', 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (1101, 13, '005031300670232000KD', 'PENGADILAN NEGERI BENGKAYANG (03)', 'general', 'Bengkayang', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Singkawang', 'Kantor Wilayah DJKN Kalimantan Barat', 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (1102, 14, '005031400400359000KD', 'PENGADILAN TINGGI PALANGKA RAYA', 'tingkatbanding', 'Palangkaraya', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1103, 14, '005031400679426000KD', 'PENGADILAN NEGERI KASONGAN', 'general', 'Kasongan', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Palangkaraya', 'Kantor Wilayah DJKN Kalimantan Selatan Dan Tengah', 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (1104, 15, '005031500099253000KD', 'PENGADILAN TINGGI BANJARMASIN', 'tingkatbanding', 'Banjarmasin', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1105, 15, '005031500099255000KD', 'PENGADILAN NEGERI KANDANGAN', 'general', 'Kandangan', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1106, 15, '005031500099258000KD', 'PN MARTAPURA', 'general', 'Martapura', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1107, 15, '005031500099259000KD', 'PENGADILAN NEGERI TANJUNG', 'general', 'Tanjung', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1108, 15, '005031500400283000KD', 'PENGADILAN NEGERI PELAIHARI', 'general', 'Pleihari', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1109, 15, '005031500653459000KD', 'PENGADILAN NEGERI BANJARBARU', 'general', 'Banjarbaru', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banjarmasin', 'Kantor Wilayah DJKN Kalimantan Selatan Dan Tengah', 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (1110, 16, '005031600099287000KD', 'PENGADILAN NEGERI SAMARINDA 03', 'general', 'Samarinda', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1111, 16, '005031600099291000KD', 'PENGADILAN NEGERI TENGGARONG', 'general', 'Tenggarong', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1112, 16, '005031600099309000KD', 'PENGADILAN NEGERI KLAS IA BALIKPAPAN', 'general', 'Balikpapan', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1113, 16, '005031600400292000KD', 'PENGADILAN NEGERI TANJUNG REDEB', 'general', 'Tanjung Redep', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1114, 16, '005031600400303000KD', 'PENGADILAN NEGERI TANAH GROGOT', 'general', 'Tanah Grogot', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1115, 16, '005031600400529000KD', 'PENGADILAN TINGGI SAMARINDA', 'tingkatbanding', 'Samarinda', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1116, 16, '005031600477381000KD', 'PENGADILAN NEGERI KUTAI BARAT', 'general', 'Kutai Barat', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Samarinda', 'Kantor Wilayah DJKN Kalimantan Timur Dan Utara', 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1117, 16, '005031600662973000KD', 'PENGADILAN NEGERI BONTANG', 'general', 'Bontang', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bontang', 'Kantor Wilayah DJKN Kalimantan Timur Dan Utara', 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (1118, 16, '005031600662987000KD', 'PENGADILAN NEGERI SANGATTA', 'general', 'Sangatta', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bontang', 'Kantor Wilayah DJKN Kalimantan Timur Dan Utara', 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (1119, 17, '005031700099313000KD', 'PENGADILAN TINGGI MANADO', 'tingkatbanding', 'Manado', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1120, 17, '005031700099330000KD', 'PENGADILAN NEGERI MANADO', 'general', 'Manado', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1121, 17, '005031700099334000KD', 'PENGADILAN NEGERI KOTAMOBAGU', 'general', 'Kotamubago', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1122, 17, '005031700099341000KD', 'PENGADILAN NEGERI TAHUNA', 'general', 'Tahuna', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1123, 17, '005031700099355000KD', 'PENGADILAN NEGERI TONDANO', 'general', 'Tondano', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1124, 17, '005031700568726000KD', 'PENGADILAN NEGERI BITUNG', 'general', 'Bitung', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1125, 17, '005031700670211000KD', 'PENGADILAN NEGERI AIRMADIDI', 'general', 'Airmadidi', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Manado', 'Kantor Wilayah DJKN Sulawesi Utara, Tengah, Gorontalo Dan Maluku Utara', 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (1126, 17, '005031700673035000KD', 'PENGADILAN NEGERI AMURANG', 'general', 'Amurang', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Manado', 'Kantor Wilayah DJKN Sulawesi Utara, Tengah, Gorontalo Dan Maluku Utara', 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (1127, 18, '005031800400535000KD', 'PENGADILAN TINGGI SULAWESI TENGAH', 'tingkatbanding', 'Palu', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1128, 19, '005031900099419000KD', 'PENGADILAN TINGGI MAKASSAR', 'tingkatbanding', 'Ujung Pandang', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1129, 19, '005031900099423000KD', 'PENGADILAN NEGERI MAKASSAR', 'general', 'Ujung Pandang', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:57', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1130, 19, '005031900099440000KD', 'Pengadilan Negeri Sungguminasa (03)', 'general', 'Sungguminasa', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1131, 19, '005031900099444000KD', 'PENGADILAN NEGERI PANGKAJENE', 'general', 'Pangkajene', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1132, 19, '005031900099451000KD', 'PENGADILAN NEGERI BARRU', 'general', 'Barru', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1133, 19, '005031900099465000KD', 'PENGADILAN NEGERI TAKALAR', 'general', 'Takalar', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1134, 19, '005031900099472000KD', 'PENGADILAN NEGERI MAROS', 'general', 'Maros', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1135, 19, '005031900099486000KD', 'PENGADILAN NEGERI JENEPONTO', 'general', 'Jeneponto', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1136, 19, '005031900099493000KD', 'PN.PAREPARE', 'general', 'Pare-Pare', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1137, 19, '005031900099508000KD', 'PENGADILAN NEGERI ENREKANG', 'general', 'Enrekang', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1138, 19, '005031900099512000KD', 'PENGADILAN NEGERI SIDRAP', 'general', 'Sidenreng Rappang', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1139, 19, '005031900099529000KD', 'PENGADILAN NEGERI PINRANG', 'general', 'Pinrang', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1140, 19, '005031900099533000KD', 'PENGADILAN NEGERI WATAMPONE 03', 'general', 'Watampone', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1141, 19, '005031900099550000KD', 'PENGADILAN NEGERI WATANSOPPENG', 'general', 'Watansopeng', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1142, 19, '005031900099554000KD', 'PENGADILAN NEGERI SENGKANG', 'general', 'Sengkang', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1143, 19, '005031900099561000KD', 'PENGADILAN NEGERI BANTAENG', 'general', 'Banta Eng', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1144, 19, '005031900099575000KD', 'PENGADILAN NEGERI SINJAI', 'general', 'Sinjai', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1145, 19, '005031900099582000KD', 'PENGADILAN NEGERI BULUKUMBA', 'general', 'Bulukumba', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1146, 19, '005031900099596000KD', 'PENGADILAN NEGERI SELAYAR', 'general', 'Selayar', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1147, 19, '005031900099601000KD', 'PENGADILAN NEGERI KELAS I B PALOPO', 'general', 'Palopo', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1148, 19, '005031900099618000KD', 'PENGADILAN NEGERI MAKALE', 'general', 'Makale', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1149, 19, '005031900672928000KD', 'PENGADILAN NEGERI MASAMBA', 'general', 'Masamba', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Palopo', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (1150, 19, '005031900673014000KD', 'PENGADILAN NEGERI MALILI', 'general', 'Malili', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Palopo', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (1151, 20, '005032000099660000KD', 'PENGADILAN NEGERI KENDARI', 'general', 'Kendari', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1152, 20, '005032000099664000KD', 'PENGADILAN NEGERI KLAS IB BAUBAU 03', 'general', 'Bau-Bau', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1153, 20, '005032000099671000KD', 'PENGADILAN NEGERI RAHA', 'general', 'Raha', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1154, 20, '005032000099685000KD', 'PENGADILAN NEGERI KOLAKA', 'general', 'Kolaka', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1155, 20, '005032000400541000KD', 'PT KENDARI', 'general', 'Kendari', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1156, 20, '005032000477225000KD', 'PENGADILAN NEGERI UNAAHA', 'general', 'Una Aha', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1157, 20, '005032000681444000KD', 'PENGADILAN NEGERI PASARWAJO', 'general', 'Pasarwajo', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kendari', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (1158, 21, '005032100099692000KD', 'PENGADILAN TINGGI AMBON', 'tingkatbanding', 'Ambon', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1159, 21, '005032100099707000KD', 'PENGADILAN NEGERI AMBON', 'general', 'Ambon', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1160, 21, '005032100099711000KD', 'PENGADILAN NEGERI MASOHI', 'general', 'Masohi', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1161, 21, '005032100672932000KD', 'PENGADILAN NEGERI SAUMLAKI', 'general', 'Saumlaki', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Ambon', 'Kantor Wilayah DJKN Papua, Papua Barat Dan Maluku', 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (1162, 22, '005032200099774000KD', 'PENGADILAN TINGGI  DENPASAR', 'tingkatbanding', 'Denpasar', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1163, 22, '005032200099781000KD', 'PENGADILAN NEGERI DENPASAR', 'general', 'Denpasar', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1164, 22, '005032200099795000KD', 'PENGADILAN NEGERI SINGARAJA', 'general', 'Singaraja', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1165, 22, '005032200099803000KD', 'PENGADILAN NEGERI NEGARA', 'general', 'Negara', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1166, 22, '005032200099817000KD', 'PENGADILAN NEGERI SEMARAPURA', 'general', 'Klungkung', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1167, 22, '005032200099821000KD', 'PENGADILAN NEGERI TABANAN', 'general', 'Tabanan', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1168, 22, '005032200099838000KD', 'PENGADILAN NEGERI AMLAPURA', 'general', 'Karangasem', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1169, 22, '005032200099842000KD', 'PENGADILAN NEGERI GIANYAR', 'general', 'Gianyar', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1170, 22, '005032200099859000KD', 'PENGADILAN NEGERI BANGLI', 'general', 'Bangli', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1171, 23, '005032300099863000KD', 'PENGADILAN NEGERI MATARAM', 'general', 'Mataram', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1172, 23, '005032300099880000KD', 'PENGADILAN NEGERI KLAS IB RABA BIMA (03)', 'general', 'Raba/Bima', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1173, 23, '005032300099884000KD', 'PENGADILAN NEGERI SUMBAWA BESAR (03)', 'general', 'Sumbawa Besar', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1174, 23, '005032300099891000KD', 'PENGADILAN NEGERI SELONG', 'general', 'Selong', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1175, 23, '005032300099906000KD', 'PENGADILAN NEGERI DOMPU (03)', 'general', 'Dompu', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1176, 23, '005032300099913000KD', 'PENGADILAN NEGERI PRAYA', 'general', 'Praya', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1177, 23, '005032300400560000KD', 'PENGADILAN TINGGI MATARAM', 'tingkatbanding', 'Mataram', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1178, 24, '005032400099948000KD', 'PENGADILAN NEGERI SOE', 'general', 'So`e', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1179, 24, '005032400099952000KD', 'PENGADILAN NEGERI KEFAMENANU', 'general', 'Kefamenanu', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1180, 24, '005032400099973000KD', 'PENGADILAN NEGERI WAIKABUBAK', 'general', 'Waikabubak', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1181, 24, '005032400099994000KD', 'PENGADILAN NEGERI MAUMERE', 'general', 'Maumere', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1182, 24, '005032400400008000KD', 'PENGADILAN NEGERI LARANTUKA', 'general', 'Larantuka', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1183, 24, '005032400400014000KD', 'PENGADILAN NEGERI RUTENG', 'general', 'Ruteng', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1184, 24, '005032400400158000KD', 'PENGADILAN NEGERI BAJAWA', 'general', 'Bajawa', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1185, 24, '005032400400164000KD', 'PENGADILAN NEGERI KALABAHI', 'general', 'Kalabahi', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1186, 24, '005032400400246000KD', 'PENGADILAN TINGGI KUPANG', 'tingkatbanding', 'Kupang', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1187, 24, '005032400673021000KD', 'PENGADILAN NEGERI LABUAN BAJO', 'general', 'Labuan Bajo', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kupang', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (1188, 25, '005032500400023000KD', 'PENGADILAN TINGGI JAYAPURA', 'tingkatbanding', 'Jayapura', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1189, 25, '005032500400039000KD', 'PENGADILAN NEGERI JAYAPURA', 'general', 'Jayapura', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1190, 25, '005032500400091000KD', 'PENGADILAN NEGERI BIAK (03)', 'general', 'Biak', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1191, 25, '005032500400102000KD', 'PENGADILAN NEGERI NABIRE (03)', 'general', 'Nabire', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1192, 25, '005032500400277000KD', 'PENGADILAN NEGERI SERUI (03)', 'general', 'Serui', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1193, 25, '005032500614891000KD', 'PENGADILAN NEGERI KOTA TIMIKA', 'general', 'Mimika', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1194, 26, '005032600400111000KD', 'PENGADILAN NEGERI BENGKULU', 'general', 'Bengkulu', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bengkulu', 'Kantor Wilayah DJKN Lampung Dan Bengkulu', 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1195, 26, '005032600400127000KD', 'PENGADILAN NEGERI CURUP', 'general', 'Curup', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bengkulu', 'Kantor Wilayah DJKN Lampung Dan Bengkulu', 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1196, 26, '005032600400133000KD', 'PENGADILAN NEGERI MANNA 03', 'general', 'Manna', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bengkulu', 'Kantor Wilayah DJKN Lampung Dan Bengkulu', 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1197, 26, '005032600400240000KD', 'PENGADILAN NEGERI ARGA MAKMUR', 'general', 'Arga Makmur', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bengkulu', 'Kantor Wilayah DJKN Lampung Dan Bengkulu', 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1198, 26, '005032600400513000KD', 'PENGADILAN TINGGI BENGKULU', 'tingkatbanding', 'Bengkulu', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bengkulu', 'Kantor Wilayah DJKN Lampung Dan Bengkulu', 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1199, 26, '005032600672995000KD', 'PENGADILAN NEGERI BINTUHAN', 'general', 'Bintuhan', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bengkulu', 'Kantor Wilayah DJKN Lampung Dan Bengkulu', 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (1200, 26, '005032600673010000KD', 'PENGADILAN NEGERI TAIS', 'general', 'Tais', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bengkulu', 'Kantor Wilayah DJKN Lampung Dan Bengkulu', 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (1201, 26, '005032600673042000KD', 'PENGADILAN NEGERI KEPAHIANG', 'general', 'Kepahiang', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bengkulu', 'Kantor Wilayah DJKN Lampung Dan Bengkulu', 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (1202, 26, '005032600673056000KD', 'PENGADILAN NEGERI TUBEI', 'general', 'Tubei', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bengkulu', 'Kantor Wilayah DJKN Lampung Dan Bengkulu', 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (1203, 27, '005032800099749000KD', 'PENGADILAN NEGERI TOBELO', 'general', 'Tobelo', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1204, 27, '005032800664523000KD', 'PENGADILAN TINGGI MALUKU UTARA', 'tingkatbanding', 'Maluku Utara', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Ternate', 'Kantor Wilayah DJKN Sulawesi Utara, Tengah, Gorontalo Dan Maluku Utara', 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (1205, 28, '005032900099074000KD', 'PENGADILAN NEGERI SERANG', 'general', 'Serang', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1206, 28, '005032900099075000KD', 'PENGADILAN NEGERI RANGKASBITUNG', 'general', 'Rangkas Bitung', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1207, 28, '005032900099077000KD', 'PENGADILAN NEGERI TANGERANG', 'general', 'Tangerang', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1208, 28, '005032900417845000KD', 'PENGADILAN NEGERI PANDEGLANG', 'general', 'Pandeglang', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Serang', 'Kantor Wilayah DJKN Banten', 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1209, 28, '005032900663399000KD', 'PENGADILAN TINGGI BANTEN', 'tingkatbanding', 'Banten', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Serang', 'Kantor Wilayah DJKN Banten', 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (1210, 29, '005033000099234000KD', 'PENGADILAN NEGERI PANGKALPINANG', 'general', 'Pangkal Pinang', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1211, 29, '005033000099235000KD', 'PENGADILAN NEGERI SUNGAILIAT', 'general', 'Sungai Liat', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1212, 29, '005033000400601000KD', 'PENGADILAN NEGERI TANJUNGPANDAN', 'general', 'Tanjung Pandan', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pangkalpinang', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1213, 29, '005033000663404000KD', 'PENGADILAN TINGGI BANGKA BELITUNG', 'tingkatbanding', 'Bangka Belitung', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pangkalpinang', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (1214, 30, '005033100099362000KD', 'PENGADILAN NEGERI GORONTALO (03)', 'general', 'Gorontalo', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1215, 30, '005033100400209000KD', 'PENGADILAN NEGERI LIMBOTO (03)', 'general', 'Limboto', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1216, 30, '005033100477219000KD', 'PENGADILAN NEGERI TILAMUTA (03)', 'general', 'Tilamuta', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1217, 30, '005033100664540000KD', 'PENGADILAN TINGGI GORONTALO (03)', 'tingkatbanding', 'Gorontalo', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Gorontalo', 'Kantor Wilayah DJKN Sulawesi Utara, Tengah, Gorontalo Dan Maluku Utara', 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (1218, 30, '005033100670185000KD', 'PENGADILAN NEGERI MARISA (03)', 'general', 'Marisa', 'Badan Peradilan Umum', 'Kantor Pelayanan Kekayaan Negara dan Lelang Gorontalo', 'Kantor Wilayah DJKN Sulawesi Utara, Tengah, Gorontalo Dan Maluku Utara', 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (1219, 31, '005033200109064000KD', 'PENGADILAN NEGERI BATAM', 'general', 'Batam', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1220, 32, '005033300400070000KD', 'PENGADILAN NEGERI MANOKWARI', 'general', 'Manokwari', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1221, 32, '005033300400076000KD', 'PENGADILAN NEGERI SORONG', 'general', 'Sorong', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1222, 32, '005033300400082000KD', 'PENGADILAN NEGERI FAKFAK', 'general', 'Fak Fak', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1223, 33, '005033400099622000KD', 'PENGADILAN NEGERI MAJENE', 'general', 'Majene', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1224, 33, '005033400099639000KD', 'PENGADILAN NEGERI MAMUJU', 'general', 'Mamuju', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1225, 33, '005033400099643000KD', 'PENGADILAN NEGERI POLEWALI', 'general', 'Polewali', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1226, 33, '005033400689980000KD', 'PENGADILAN NEGERI PASANGKAYU', 'general', 'Pasangkayu', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (1227, 34, '005033500099273000KD', 'PENGADILAN NEGERI TARAKAN', 'general', 'Tarakan', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1228, 34, '005033500417705000KD', 'PENGADILAN NEGERI MALINAU', 'general', 'Malinau', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1229, 34, '005033500417723000KD', 'PENGADILAN NEGERI TANJUNG SELOR', 'general', 'Tanjung Selor', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1230, 34, '005033500477271000KD', 'Pengadilan Negeri Nunukan', 'general', 'Nunukan', 'Badan Peradilan Umum', NULL, NULL, 'PN', NULL, '2020-12-23 12:02:58', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1231, 1, '005040100400617000KD', 'PENGADILAN AGAMA JAKARTA PUSAT', 'general', 'Jakarta Pusat', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jakarta I', 'Kantor Wilayah DJKN DKI Jakarta', 'PA', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1232, 1, '005040100400623000KD', 'PENGADILAN AGAMA JAKARTA UTARA', 'general', 'Jakarta Utara', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jakarta I', 'Kantor Wilayah DJKN DKI Jakarta', 'PA', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1233, 1, '005040100400632000KD', 'PENGADILAN AGAMA JAKARTA BARAT (04)', 'general', 'Jakarta Barat', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jakarta I', 'Kantor Wilayah DJKN DKI Jakarta', 'PA', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1234, 1, '005040100400654000KD', 'PENGADILAN AGAMA JAKARTA SELATAN (04)', 'general', 'Jakarta Selatan', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jakarta I', 'Kantor Wilayah DJKN DKI Jakarta', 'PA', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1235, 1, '005040100401113000KD', 'PENGADILAN TINGGI AGAMA JAKARTA', 'tingkatbanding', 'Jakarta', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jakarta I', 'Kantor Wilayah DJKN DKI Jakarta', 'PA', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1236, 2, '005040200309124000KD', 'PENGADILAN TINGGI AGAMA BANDUNG (04)', 'tingkatbanding', 'Bandung', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bandung', 'Kantor Wilayah DJKN Jawa Barat', 'PA', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1237, 2, '005040200400663000KD', 'PENGADILAN AGAMA BANDUNG (04)', 'general', 'Bandung', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bandung', 'Kantor Wilayah DJKN Jawa Barat', 'PA', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1238, 2, '005040200400679000KD', 'PENGADILAN AGAMA SUMEDANG', 'general', 'Sumedang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bandung', 'Kantor Wilayah DJKN Jawa Barat', 'PA', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1239, 2, '005040200400685000KD', 'PENGADILAN AGAMA CIMAHI (04)', 'general', NULL, NULL, NULL, NULL, 'PA', NULL, '2020-12-23 12:02:58', '2021-03-13 12:37:04');
INSERT INTO `satkers` VALUES (1240, 2, '005040200400691000KD', 'PENGADILAN AGAMA CIAMIS', 'general', 'Ciamis', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Tasikmalaya', 'Kantor Wilayah DJKN Jawa Barat', 'PA', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1241, 2, '005040200400705000KD', 'PENGADILAN AGAMA TASIKMALAYA', 'general', 'Tasikmalaya', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Tasikmalaya', 'Kantor Wilayah DJKN Jawa Barat', 'PA', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1242, 2, '005040200400711000KD', 'PENGADILAN AGAMA GARUT', 'general', 'Garut', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Tasikmalaya', 'Kantor Wilayah DJKN Jawa Barat', 'PA', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1243, 2, '005040200400736000KD', 'PENGADILAN AGAMA SUKABUMI', 'general', 'Sukabumi', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bogor', 'Kantor Wilayah DJKN Jawa Barat', 'PA', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1244, 2, '005040200400751000KD', 'PA CIREBON', 'general', 'Cirebon', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Cirebon', 'Kantor Wilayah DJKN Jawa Barat', 'PA', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1245, 2, '005040200400767000KD', 'PA INDRAMAYU', 'general', 'Indramayu', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Cirebon', 'Kantor Wilayah DJKN Jawa Barat', 'PA', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1246, 2, '005040200400773000KD', 'Pengadilan Agama Majalengka', 'general', 'Majalengka', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Cirebon', 'Kantor Wilayah DJKN Jawa Barat', 'PA', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1247, 2, '005040200400782000KD', 'PENGADILAN AGAMA KUNINGAN II', 'general', 'Kuningan', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Cirebon', 'Kantor Wilayah DJKN Jawa Barat', 'PA', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1248, 2, '005040200400849000KD', 'PENGADILAN AGAMA  KARAWANG (04)', 'general', 'Karawang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Purwakarta', 'Kantor Wilayah DJKN Jawa Barat', 'PA', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1249, 2, '005040200400855000KD', 'PENGADILAN AGAMA PURWAKARTA', 'general', 'Purwakarta', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Purwakarta', 'Kantor Wilayah DJKN Jawa Barat', 'PA', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1250, 2, '005040200402588000KD', 'PENGADILAN AGAMA SUBANG', 'general', 'Subang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Purwakarta', 'Kantor Wilayah DJKN Jawa Barat', 'PA', NULL, '2020-12-23 12:02:58', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1251, 2, '005040200402996000KD', 'PENGADILAN AGAMA CIBADAK', 'general', 'Cibadak', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bogor', 'Kantor Wilayah DJKN Jawa Barat', 'PA', NULL, '2020-12-23 12:02:58', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1252, 2, '005040200403010000KD', 'PENGADILAN AGAMA SUMBER', 'general', 'Sumber', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Cirebon', 'Kantor Wilayah DJKN Jawa Barat', 'PA', NULL, '2020-12-23 12:02:58', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1253, 2, '005040200604720000KD', 'PENGADIAN AGAMA CIBINONG', 'general', 'Cibinong', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bogor', 'Kantor Wilayah DJKN Jawa Barat', 'PA', NULL, '2020-12-23 12:02:58', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1254, 2, '005040200652063000KD', 'PENGADILAN AGAMA DEPOK', 'general', 'Depok', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bogor', 'Kantor Wilayah DJKN Jawa Barat', 'PA', NULL, '2020-12-23 12:02:58', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (1255, 2, '005040200690023000KD', 'PENGADILAN AGAMA KOTA TASIKMALAYA', 'general', 'Kota Tasikmalaya', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Tasikmalaya', 'Kantor Wilayah DJKN Jawa Barat', 'PA', NULL, '2020-12-23 12:02:58', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (1256, 2, '005040200690030000KD', 'PENGADILAN AGAMA KOTA BANJAR', 'general', 'Kota Banjar', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Tasikmalaya', 'Kantor Wilayah DJKN Jawa Barat', 'PA', NULL, '2020-12-23 12:02:58', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (1257, 3, '005040300400861000KD', 'PENGADILAN AGAMA PEKALONGAN', 'general', 'Pekalongan', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pekalongan', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1258, 3, '005040300400880000KD', 'PENGADILAN AGAMA PEMALANG (04)', 'general', 'Pemalang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Tegal', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1259, 3, '005040300400886000KD', 'PENGADILAN AGAMA TEGAL', 'general', 'Tegal', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Tegal', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1260, 3, '005040300400892000KD', 'PENGADILAN AGAMA BREBES', 'general', 'Brebes', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Tegal', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1261, 3, '005040300400906000KD', 'PENGADILAN AGAMA BATANG', 'general', 'Batang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pekalongan', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1262, 3, '005040300400912000KD', 'PENGADILAN AGAMA SEMARANG', 'general', 'Semarang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Semarang', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1263, 3, '005040300400921000KD', 'PENGADILAN AGAMA SALATIGA', 'general', 'Salatiga', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Semarang', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1264, 3, '005040300400937000KD', 'PENGADILAN AGAMA KENDAL', 'general', 'Kendal', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pekalongan', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1265, 3, '005040300400943000KD', 'PENGADILAN AGAMA DEMAK', 'general', 'Demak', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Semarang', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1266, 3, '005040300400952000KD', 'PENGADILAN AGAMA PURWODADI', 'general', 'Purwodadi', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Semarang', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1267, 3, '005040300400968000KD', 'PENGADILAN AGAMA PATI', 'general', 'Pati', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Semarang', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1268, 3, '005040300400974000KD', 'PA. KUDUS', 'general', 'Kudus', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Semarang', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1269, 3, '005040300400983000KD', 'PENGADILAN AGAMA JEPARA', 'general', 'Jepara', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Semarang', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1270, 3, '005040300400999000KD', 'PENGADILAN AGAMA REMBANG', 'general', 'Rembang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Semarang', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1271, 3, '005040300401003000KD', 'PENGADILAN AGAMA BLORA (BADILAG)', 'general', 'Blora', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Semarang', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1272, 3, '005040300401019000KD', 'PA MAGELANG', 'general', 'Magelang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Semarang', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1273, 3, '005040300401025000KD', 'PENGADILAN AGAMA TEMANGGUNG', 'general', 'Temanggung', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Semarang', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1274, 3, '005040300401031000KD', 'PENGADILAN AGAMA WONOSOBO', 'general', 'Wonosobo', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Purwokerto', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1275, 3, '005040300401050000KD', 'PENGADILAN AGAMA PURWOREJO', 'general', 'Purworejo', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Purwokerto', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1276, 3, '005040300401056000KD', 'PENGADILAN AGAMA KEBUMEN (04)', 'general', 'Kebumen', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Purwokerto', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1277, 3, '005040300401062000KD', 'PENGADILAN AGAMA PURWOKERTO 04', 'general', 'Purwokerto', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Purwokerto', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1278, 3, '005040300401071000KD', 'PEGADILAN AGAMA BANYUMAS', 'general', 'Banyumas', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Purwokerto', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1279, 3, '005040300401087000KD', 'PENGADILAN AGAMA CILACAP', 'general', 'Cilacap', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Purwokerto', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1280, 3, '005040300401093000KD', 'PA PURBALINGGA (04)', 'general', 'Purbalingga', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Purwokerto', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1281, 3, '005040300401107000KD', 'PENGADILAN AGAMA BANJARNEGARA', 'general', 'Banjarnegara', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Purwokerto', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1282, 3, '005040300401138000KD', 'PENGADILAN AGAMA BOYOLALI (04)', 'general', 'Boyolali', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Surakarta', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1283, 3, '005040300401144000KD', 'PENGADILAN AGAMA SRAGEN', 'general', 'Sragen', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Surakarta', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2020-12-23 12:02:58', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1284, 3, '005040300401153000KD', 'PENGADILAN AGAMA WONOGIRI', 'general', 'Wonogiri', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Surakarta', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1285, 3, '005040300401169000KD', 'PENGADILAN AGAMA SUKOHARJO', 'general', 'Sukoharjo', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Surakarta', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1286, 3, '005040300401175000KD', 'PENGADILAN AGAMA KARANGANYAR (04)', 'general', 'Karanganyar', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Surakarta', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1287, 3, '005040300401181000KD', 'PENGADILAN AGAMA SURAKARTA', 'general', 'Surakarta', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Surakarta', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1288, 3, '005040300402594000KD', 'PENGADILAN AGAMA AMBARAWA', 'general', 'Ambarawa', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Semarang', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1289, 3, '005040300402965000KD', 'PENGADILAN TINGGI AGAMA SEMARANG (04)', 'tingkatbanding', 'Semarang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Semarang', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1290, 3, '005040300403016000KD', 'PENGADILAN AGAMA SLAWI (04)', 'general', 'Slawi', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Tegal', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1291, 3, '005040300403022000KD', 'PENGADILAN AGAMA MUNGKID', 'general', 'Mungkid', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Semarang', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1292, 3, '005040300614711000KD', 'PENGADILAN AGAMA KAJEN', 'general', 'Kajen', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pekalongan', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1293, 4, '005040400401201000KD', 'PA.YOGYAKARTA', 'general', 'Yogyakarta', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Yogyakarta', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1294, 4, '005040400401202000KD', 'PENGADILAN AGAMA SLEMAN', 'general', 'Sleman', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Yogyakarta', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1295, 4, '005040400401220000KD', 'PENGADILAN AGAMA WATES', 'general', 'Wates', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Yogyakarta', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1296, 4, '005040400401226000KD', 'PENGADILAN AGAMA BANTUL', 'general', 'Bantul', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Yogyakarta', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1297, 4, '005040400401232000KD', 'PENGADILAN AGAMA WONOSARI', 'general', 'Wonosari', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Yogyakarta', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1298, 5, '005040500309125000KD', 'PTA SURABAYA 04', 'general', 'Surabaya', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1299, 5, '005040500401257000KD', 'PENGADILAN AGAMA MOJOKERTO', 'general', 'Mojokerto', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1300, 5, '005040500401263000KD', 'PENGADILAN AGAMA SIDOARJO', 'general', 'Sidoarjo', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1301, 5, '005040500401272000KD', 'PENGADILAN AGAMA JOMBANG', 'general', 'Jombang', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1302, 5, '005040500401288000KD', 'PA BAWEAN 04', 'general', 'Bawean', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Surabaya', 'Kantor Wilayah DJKN Jawa Timur', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1303, 5, '005040500401294000KD', 'PA GRESIK 04', 'general', 'Gresik', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Surabaya', 'Kantor Wilayah DJKN Jawa Timur', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1304, 5, '005040500401308000KD', 'PA BOJONEGORO 4', 'general', 'Bojonegoro', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1305, 5, '005040500401323000KD', 'PENGADILAN AGAMA LAMONGAN', 'general', 'Lamongan', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1306, 5, '005040500401339000KD', 'PENGADILAN AGAMA JEMBER', 'general', 'Jember', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jember', 'Kantor Wilayah DJKN Jawa Timur', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1307, 5, '005040500401345000KD', 'PENGADILAN AGAMA BONDOWOSO', 'general', 'Bondowoso', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1308, 5, '005040500401351000KD', 'PENGADILAN AGAMA SITUBONDO', 'general', 'Situbondo', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1309, 5, '005040500401370000KD', 'PENGADILAN AGAMA BANYUWANGI', 'general', 'Banyuwangi', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jember', 'Kantor Wilayah DJKN Jawa Timur', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1310, 5, '005040500401376000KD', 'PENGADILAN AGAMA KAB. KEDIRI (04)', 'general', 'Kabupaten Kediri', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1311, 5, '005040500401382000KD', 'PENGADILAN AGAMA TULUNGAGUNG', 'general', 'Tulungagung', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1312, 5, '005040500401403000KD', 'PENGADILAN AGAMA BLITAR', 'general', 'Blitar', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1313, 5, '005040500401411000KD', 'PENGADILAN AGAMA NGANJUK 04', 'general', 'Nganjuk', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1314, 5, '005040500401427000KD', 'PENGADILAN AGAMA MALANG', 'general', 'Malang', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1315, 5, '005040500401433000KD', 'PENGADILAN AGAMA PASURUAN', 'general', 'Pasuruan', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1316, 5, '005040500401442000KD', 'PA BANGIL (04)', 'general', 'Bangil', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1317, 5, '005040500401458000KD', 'PENGADILAN AGAMA PROBOLINGGO', 'general', 'Probolinggo', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1318, 5, '005040500401464000KD', 'PA KRAKSAAN', 'general', 'Kraksaan', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1319, 5, '005040500401473000KD', 'PENGADILAN AGAMA LUMAJANG', 'general', 'Lumajang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Malang', 'Kantor Wilayah DJKN Jawa Timur', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1320, 5, '005040500401489000KD', 'PENGADILAN AGAMA KOTA MADIUN (04)', 'general', 'Madiun', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1321, 5, '005040500401495000KD', 'PENGADILAN AGAMA MAGETAN', 'general', 'Magetan', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1322, 5, '005040500401509000KD', 'PENGADILAN AGAMA NGAWI', 'general', 'Ngawi', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1323, 5, '005040500401515000KD', 'PENGADILAN AGAMA PONOROGO', 'general', 'Ponorogo', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1324, 5, '005040500401540000KD', 'PENGADILAN AGAMA PAMEKASAN', 'general', 'Pamekasan', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1325, 5, '005040500401546000KD', 'PENGADILAN AGAMA BANGKALAN', 'general', 'Bangkalan', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1326, 5, '005040500401552000KD', 'PENGADILAN AGAMA SAMPANG', 'general', 'Sampang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pamekasan', 'Kantor Wilayah DJKN Jawa Timur', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1327, 5, '005040500401561000KD', 'PENGADILAN AGAMA SUMENEP', 'general', 'Sumenep', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1328, 5, '005040500401577000KD', 'PENGADILAN AGAMA KANGEAN', 'general', 'Kangean', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1329, 5, '005040500403031000KD', 'PENGADILAN AGAMA KAB. MADIUN (04)', 'general', 'Kabupaten Madiun', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Madiun', 'Kantor Wilayah DJKN Jawa Timur', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1330, 5, '005040500403047000KD', 'PENGADILAN AGAMA KEDIRI', 'general', 'Kediri', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Malang', 'Kantor Wilayah DJKN Jawa Timur', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1331, 5, '005040500450738000KD', 'PA TUBAN', 'general', 'Tuban', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Surabaya', 'Kantor Wilayah DJKN Jawa Timur', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1332, 5, '005040500604731000KD', 'PENGADILAN AGAMA KAB. MALANG', 'general', 'Malang Kab. Malang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Malang', 'Kantor Wilayah DJKN Jawa Timur', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1333, 6, '005040600401592000KD', 'MAHKAMAH SYAR\'IYAH BANDA ACEH 04', 'general', 'Banda Aceh', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banda Aceh', 'Kantor Wilayah DJKN Aceh', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1334, 6, '005040600401603000KD', 'MS SABANG', 'general', 'Sabang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banda Aceh', 'Kantor Wilayah DJKN Aceh', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1335, 6, '005040600401612000KD', 'MS SIGLI', 'general', 'Sigli', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banda Aceh', 'Kantor Wilayah DJKN Aceh', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1336, 6, '005040600401628000KD', 'MAHKAMAH SYAR\'IYAH MEUREUDU', 'general', 'Meureudu', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banda Aceh', 'Kantor Wilayah DJKN Aceh', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1337, 6, '005040600401634000KD', 'MAHKAMAH SYAR\'IYAH BIREUEN', 'general', 'Bireuen', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Lhokseumawe', 'Kantor Wilayah DJKN Aceh', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1338, 6, '005040600401643000KD', 'MAHKAMAH SYAR\'IYAH LHOKSUKON', 'general', 'Lhok Sukon', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Lhokseumawe', 'Kantor Wilayah DJKN Aceh', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1339, 6, '005040600401671000KD', 'MAHKAMAH SYAR IYAH IDI', 'general', 'Idi', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Lhokseumawe', 'Kantor Wilayah DJKN Aceh', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1340, 6, '005040600401690000KD', 'MAHKAMAH SYAR\'IYAH LANGSA', 'general', 'Langsa', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Lhokseumawe', 'Kantor Wilayah DJKN Aceh', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1341, 6, '005040600401696000KD', 'MAHKAMAH SYAR\'IYAH KUALASIMPANG', 'general', 'Kuala Simpang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Lhokseumawe', 'Kantor Wilayah DJKN Aceh', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1342, 6, '005040600401710000KD', 'MAHKAMAH SYAR\'IYAH BLANGKEJEREN', 'general', 'Blangkajeren', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Lhokseumawe', 'Kantor Wilayah DJKN Aceh', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1343, 6, '005040600401716000KD', 'MAHKAMAH SYAR\'IYAH KUTACANE', 'general', 'Kotacane', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Lhokseumawe', 'Kantor Wilayah DJKN Aceh', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1344, 6, '005040600401722000KD', 'MAHKAMAH SYAR\'IYAH MEULABOH', 'general', 'Meulaboh', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banda Aceh', 'Kantor Wilayah DJKN Aceh', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1345, 6, '005040600401747000KD', 'MS CALANG', 'general', 'Calang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banda Aceh', 'Kantor Wilayah DJKN Aceh', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1346, 6, '005040600401753000KD', 'MAHKAMAH SYAR\'IYAH SINGKIL', 'general', 'Singkil', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banda Aceh', 'Kantor Wilayah DJKN Aceh', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1347, 6, '005040600402608000KD', 'MAHKAMAH SYAR\'IYAH JANTHO', 'general', 'Jantho', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banda Aceh', 'Kantor Wilayah DJKN Aceh', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1348, 6, '005040600690108000KD', 'MAHKAMAH SYAR\'IYAH SIMPANG TIGA REDELONG', 'general', 'Simpang Tiga Redelong', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (1349, 7, '005040700401778000KD', 'PENGADILAN TINGGI AGAMA MEDAN', 'tingkatbanding', 'Medan', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Medan', 'Kantor Wilayah DJKN Sumatera Utara', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1350, 7, '005040700401793000KD', 'PENGADILAN AGAMA KABANJAHE', 'general', 'Kabanjahe', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Medan', 'Kantor Wilayah DJKN Sumatera Utara', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1351, 7, '005040700401829000KD', 'PENGADILAN AGAMA TANJUNGBALAI', 'general', 'Tanjung Balai', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kisaran', 'Kantor Wilayah DJKN Sumatera Utara', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1352, 7, '005040700401841000KD', 'PENGADILAN AGAMA SIDIKALANG', 'general', 'Sidikalang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pematang Siantar', 'Kantor Wilayah DJKN Sumatera Utara', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1353, 7, '005040700401860000KD', 'PENGADILAN AGAMA PEMATANGSIANTAR', 'general', 'Pematang Siantar', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pematang Siantar', 'Kantor Wilayah DJKN Sumatera Utara', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1354, 7, '005040700401866000KD', 'PENGADILAN AGAMA BALIGE', 'general', 'Balige', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pematang Siantar', 'Kantor Wilayah DJKN Sumatera Utara', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1355, 7, '005040700401872000KD', 'PENGADILAN AGAMA SIBOLGA', 'general', 'Sibolga', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Padangsidimpuan', 'Kantor Wilayah DJKN Sumatera Utara', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1356, 7, '005040700401881000KD', 'PENGADILAN AGAMA PADANGSIDIMPUAN', 'general', 'Padang Sidempuan', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Padangsidimpuan', 'Kantor Wilayah DJKN Sumatera Utara', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1357, 7, '005040700401897000KD', 'PENGADILAN AGAMA GUNUNGSITOLI', 'general', 'Gunung Sitoli', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Padangsidimpuan', 'Kantor Wilayah DJKN Sumatera Utara', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1358, 7, '005040700403062000KD', 'PA KISARAN', 'general', 'Kisaran', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kisaran', 'Kantor Wilayah DJKN Sumatera Utara', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1359, 7, '005040700403084000KD', 'PENGADILAN AGAMA SIMALUNGUN', 'general', 'Simalungun', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pematang Siantar', 'Kantor Wilayah DJKN Sumatera Utara', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1360, 7, '005040700604745000KD', 'PENGADILAN AGAMA PANDAN', 'general', 'Pandan', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Padangsidimpuan', 'Kantor Wilayah DJKN Sumatera Utara', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1361, 7, '005040700631980000KD', 'PENGADILAN AGAMA TARUTUNG', 'general', 'Tarutung', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Padangsidimpuan', 'Kantor Wilayah DJKN Sumatera Utara', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1362, 7, '005040700690112000KD', 'PENGADILAN AGAMA KOTA PADANGSIDIMPUAN', 'general', 'Kota Padang Sidempuan', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Padangsidimpuan', 'Kantor Wilayah DJKN Sumatera Utara', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (1363, 8, '005040800401901000KD', 'PENGADILAN TINGGI AGAMA PADANG', 'tingkatbanding', 'Padang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Padang', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1364, 8, '005040800401917000KD', 'PENGADILAN AGAMA PARIAMAN', 'general', 'Pariaman', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Padang', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1365, 8, '005040800401923000KD', 'PENGADILAN AGAMA SOLOK', 'general', 'Solok', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Padang', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1366, 8, '005040800401932000KD', 'PENGADILAN AGAMA SAWAHLUNTO', 'general', 'Sawahlunto', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Padang', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1367, 8, '005040800401948000KD', 'PENGADILAN AGAMA BATUSANGKAR KELAS IB', 'general', 'Batusangkar', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bukittinggi', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1368, 8, '005040800401954000KD', 'PENGADILAN AGAMA PADANG', 'general', 'Padang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Padang', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1369, 8, '005040800401963000KD', 'PENGADILAN AGAMA PADANG PANJANG', 'general', 'Padang Panjang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bukittinggi', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1370, 8, '005040800401979000KD', 'PENGADILAN AGAMA SIJUNJUNG', 'general', 'Sijunjung', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Padang', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1371, 8, '005040800401985000KD', 'PENGADILAN AGAMA KOTO BARU', 'general', 'Koto Baru', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Padang', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1372, 8, '005040800401991000KD', 'PENGADILAN AGAMA MUARALABUH', 'general', 'Muara Labuh', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Padang', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1373, 8, '005040800402005000KD', 'PENGADILAN AGAMA PAINAN', 'general', 'Painan', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Padang', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1374, 8, '005040800402011000KD', 'PENGADILAN AGAMA BUKITTINGGI KELAS IB', 'tingkatbanding', 'Bukittinggi', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bukittinggi', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1375, 8, '005040800402030000KD', 'PENGADILAN AGAMA LUBUK SIKAPING', 'general', 'Lubuk Sikaping', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bukittinggi', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1376, 8, '005040800402036000KD', 'PENGADILAN AGAMA TALU', 'general', 'Talu', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bukittinggi', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1377, 8, '005040800402042000KD', 'PENGADILAN AGAMA MANINJAU (04)', 'general', 'Maninjau', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bukittinggi', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1378, 8, '005040800402051000KD', 'PENGADILAN AGAMA PAYAKUMBUH', 'general', 'Payakumbuh', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bukittinggi', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1379, 8, '005040800402067000KD', 'PENGADILAN AGAMA TANJUNG PATI', 'general', 'Tanjung Pati', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bukittinggi', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1380, 8, '005040800402614000KD', 'PENGADILAN AGAMA LUBUK BASUNG', 'general', 'Lubuk Basung', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1381, 9, '005040900402073000KD', 'PENGADILAN AGAMA PEKANBARU', 'general', 'Pekanbaru', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pekanbaru', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1382, 9, '005040900402082000KD', 'PENGADILAN AGAMA RENGAT', 'general', 'Rengat', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pekanbaru', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1383, 9, '005040900402098000KD', 'PENGADILAN AGAMA TEMBILAHAN', 'general', 'Tembilahan', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pekanbaru', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1384, 9, '005040900402102000KD', 'PENGADILAN AGAMA BANGKINANG', 'general', 'Bangkinang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pekanbaru', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1385, 9, '005040900402118000KD', 'PENGADILAN AGAMA BENGKALIS', 'general', 'Bengkalis', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Dumai', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1386, 9, '005040900402124000KD', 'PENGADILAN AGAMA PASIR PENGARAIAN', 'general', 'Pasir Pangarayan', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pekanbaru', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1387, 9, '005040900402133000KD', 'PENGADILAN AGAMA SELATPANJANG', 'general', 'Selat Panjang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Dumai', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1388, 9, '005040900402623000KD', 'PENGADILAN AGAMA DUMAI', 'general', 'Dumai', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Dumai', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1389, 9, '005040900402971000KD', 'PENGADILAN TINGGI AGAMA PEKANBARU (04)', 'tingkatbanding', 'Pekanbaru', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pekanbaru', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1390, 9, '005040900632000000KD', 'PENGADILAN AGAMA PANGKALAN KERINCI', 'general', 'Pangkalan Kerinci', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pekanbaru', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1391, 9, '005040900632002000KD', 'PENGADILAN AGAMA UJUNG TANJUNG', 'general', 'Ujung Tanjung', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Dumai', 'Kantor Wilayah DJKN Riau, Sumatera Barat, Dan Kepulauan Riau', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1392, 10, '005041000402186000KD', 'PENGADILAN AGAMA JAMBI', 'general', 'Jambi', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jambi', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1393, 10, '005041000402192000KD', 'PENGADILAN AGAMA MUARA BUNGO', 'general', 'Muara Bungo', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jambi', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1394, 10, '005041000402206000KD', 'PENGADILAN AGAMA KUALA TUNGKAL', 'general', 'Kuala Tungkal', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jambi', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1395, 10, '005041000402212000KD', 'PENGADILAN AGAMA BANGKO', 'general', 'Bangko', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jambi', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1396, 10, '005041000402221000KD', 'PENGADILAN AGAMA SUNGAI PENUH', 'general', 'Sungai Penuh', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jambi', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1397, 10, '005041000403053000KD', 'PENGADILAN AGAMA MUARA BULIAN', 'general', 'Muara Bulian', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jambi', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1398, 10, '005041000547662000KD', 'PENGADILAN TINGGI AGAMA JAMBI', 'tingkatbanding', 'Jambi', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jambi', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1399, 10, '005041000632019000KD', 'PENGADILAN AGAMA SAROLANGUN', 'general', 'Sarolangun', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jambi', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1400, 10, '005041000632023000KD', 'PENGADILAN AGAMA MUARA SABAK', 'general', 'Muara Sabak', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jambi', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1401, 10, '005041000652021000KD', 'PENGADILAN AGAMA MUARA TEBO', 'general', 'Muara Tebo', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jambi', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (1402, 10, '005041000652035000KD', 'PENGADILAN AGAMA SENGETI (04)', 'general', 'Sengeti', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jambi', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (1403, 11, '005041100402237000KD', 'PENGADILAN TINGGI AGAMA PALEMBANG', 'tingkatbanding', 'Palembang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Palembang', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1404, 11, '005041100402243000KD', 'PENGADILAN AGAMA PALEMBANG', 'general', 'Palembang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Palembang', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1405, 11, '005041100402252000KD', 'PENGADILAN AGAMA LAHAT', 'general', 'Lahat', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Lahat', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1406, 11, '005041100402268000KD', 'PENGADILAN AGAMA BATURAJA', 'general', 'Baturaja', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Palembang', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1407, 11, '005041100402274000KD', 'PENGADILAN AGAMA KAYUAGUNG', 'general', 'Kayu Agung', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Palembang', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1408, 11, '005041100402283000KD', 'PENGADILAN AGAMA MUARA ENIM', 'general', 'Muara Enim', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Lahat', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1409, 11, '005041100402299000KD', 'PENGADILAN AGAMA LUBUKLINGGAU', 'general', 'Lubuk Linggau', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Lahat', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1410, 12, '005041200402325000KD', 'PA TANJUNG KARANG', 'general', 'Tanjung Karang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bandar Lampung', 'Kantor Wilayah DJKN Lampung Dan Bengkulu', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1411, 12, '005041200402331000KD', 'PA KRUI DI LIWA', 'general', 'Krui', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bandar Lampung', 'Kantor Wilayah DJKN Lampung Dan Bengkulu', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1412, 12, '005041200402350000KD', 'PA KOTABUMI', 'general', 'Kotabumi', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Metro', 'Kantor Wilayah DJKN Lampung Dan Bengkulu', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1413, 12, '005041200402356000KD', 'PENGADILAN AGAMA METRO', 'general', 'Metro', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Metro', 'Kantor Wilayah DJKN Lampung Dan Bengkulu', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1414, 12, '005041200402645000KD', 'PA KALIANDA', 'general', 'Kalianda', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bandar Lampung', 'Kantor Wilayah DJKN Lampung Dan Bengkulu', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1415, 12, '005041200547679000KD', 'PTA BANDAR LAMPUNG', 'general', 'Bandar Lampung', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bandar Lampung', 'Kantor Wilayah DJKN Lampung Dan Bengkulu', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1416, 12, '005041200614685000KD', 'PA TULANG BAWANG', 'general', 'Tulang Bawang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Metro', 'Kantor Wilayah DJKN Lampung Dan Bengkulu', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1417, 12, '005041200614692000KD', 'PA TANGGAMUS', 'general', 'Tanggamus', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bandar Lampung', 'Kantor Wilayah DJKN Lampung Dan Bengkulu', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1418, 12, '005041200652042000KD', 'PA GUNUNG SUGIH 04', 'general', 'Gunung Sugih', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Metro', 'Kantor Wilayah DJKN Lampung Dan Bengkulu', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (1419, 12, '005041200652056000KD', 'PA. BLAMBANGAN UMPU 04', 'general', 'Blambangan Umpu', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Metro', 'Kantor Wilayah DJKN Lampung Dan Bengkulu', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (1420, 13, '005041300402362000KD', 'PENGADILAN AGAMA PONTIANAK (04)', 'general', 'Pontianak', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pontianak', 'Kantor Wilayah DJKN Kalimantan Barat', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1421, 13, '005041300402371000KD', 'PENGADILAN AGAMA SAMBAS (04)', 'general', 'Sambas', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Singkawang', 'Kantor Wilayah DJKN Kalimantan Barat', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1422, 13, '005041300402393000KD', 'PENGADILAN AGAMA SANGGAU', 'general', 'Sanggau', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pontianak', 'Kantor Wilayah DJKN Kalimantan Barat', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1423, 13, '005041300402407000KD', 'PENGADILAN AGAMA SINTANG', 'general', 'Sintang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pontianak', 'Kantor Wilayah DJKN Kalimantan Barat', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1424, 13, '005041300402413000KD', 'PENGADAILAN AGAMA PUTUSSIBAU (04)', 'general', 'Putussibau', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pontianak', 'Kantor Wilayah DJKN Kalimantan Barat', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1425, 13, '005041300402651000KD', 'PTA. PONTIANAK', 'general', 'Pontianak', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pontianak', 'Kantor Wilayah DJKN Kalimantan Barat', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1426, 13, '005041300402670000KD', 'PENGADILAN AGAMA MEMPAWAH', 'general', 'Mempawah', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pontianak', 'Kantor Wilayah DJKN Kalimantan Barat', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1427, 13, '005041300632040000KD', 'PENGADILAN AGAMA BENGKAYANG (04)', 'general', 'Bengkayang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Singkawang', 'Kantor Wilayah DJKN Kalimantan Barat', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (1428, 14, '005041400402422000KD', 'PENGADILAN AGAMA PALANGKA RAYA', 'general', 'Palangkaraya', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Palangkaraya', 'Kantor Wilayah DJKN Kalimantan Selatan Dan Tengah', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1429, 14, '005041400402438000KD', 'PENGADILAN AGAMA PANGKALAN BUN', 'general', 'Pangkalan Bun', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pangkalan Bun', 'Kantor Wilayah DJKN Kalimantan Selatan Dan Tengah', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1430, 14, '005041400402444000KD', 'PENGADILAN AGAMA MUARA TEWEH', 'general', 'Muara Tewe', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Palangkaraya', 'Kantor Wilayah DJKN Kalimantan Selatan Dan Tengah', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1431, 14, '005041400402453000KD', 'PENGADILAN AGAMA BUNTOK', 'general', 'Buntok', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Palangkaraya', 'Kantor Wilayah DJKN Kalimantan Selatan Dan Tengah', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1432, 14, '005041400402469000KD', 'PENGADILAN AGAMA KUALA KAPUAS', 'general', 'Kuala Kapuas', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Palangkaraya', 'Kantor Wilayah DJKN Kalimantan Selatan Dan Tengah', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1433, 14, '005041400402475000KD', 'PENGADILAN AGAMA SAMPIT', 'general', 'Sampit', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pangkalan Bun', 'Kantor Wilayah DJKN Kalimantan Selatan Dan Tengah', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1434, 14, '005041400402990000KD', 'PENGADILAN TINGGI AGAMA PALANGKA RAYA', 'tingkatbanding', 'Palangkaraya', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Palangkaraya', 'Kantor Wilayah DJKN Kalimantan Selatan Dan Tengah', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1435, 15, '005041500309048000KD', 'PENGADILAN AGAMA MARABAHAN', 'general', 'Marabahan', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1436, 15, '005041500309050000KD', 'PA KOTABARU', 'general', 'Kotabaru', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1437, 15, '005041500402450000KD', 'PENGADILAN TINGGI AGAMA BANJARMASIN', 'tingkatbanding', 'Banjarmasin', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banjarmasin', 'Kantor Wilayah DJKN Kalimantan Selatan Dan Tengah', 'PA', NULL, '2020-12-23 12:02:59', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1438, 15, '005041500402501000KD', 'PENGADILAN AGAMA BANJARMASIN', 'general', 'Banjarmasin', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banjarmasin', 'Kantor Wilayah DJKN Kalimantan Selatan Dan Tengah', 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1439, 15, '005041500402520000KD', 'PENGADILAN AGAMA MARTAPURA', 'general', 'Martapura', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banjarmasin', 'Kantor Wilayah DJKN Kalimantan Selatan Dan Tengah', 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1440, 15, '005041500402526000KD', 'PENGADILAN AGAMA RANTAU', 'general', 'Rantau', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banjarmasin', 'Kantor Wilayah DJKN Kalimantan Selatan Dan Tengah', 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1441, 15, '005041500402532000KD', 'PENGADILAN AGAMA KANDANGAN', 'general', 'Kandangan', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banjarmasin', 'Kantor Wilayah DJKN Kalimantan Selatan Dan Tengah', 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1442, 15, '005041500402557000KD', 'PENGADILAN AGAMA AMUNTAI', 'general', 'Amuntai', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banjarmasin', 'Kantor Wilayah DJKN Kalimantan Selatan Dan Tengah', 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1443, 15, '005041500402563000KD', 'PA TANJUNG', 'general', 'Tanjung', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banjarmasin', 'Kantor Wilayah DJKN Kalimantan Selatan Dan Tengah', 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1444, 15, '005041500402572000KD', 'PENGADILAN AGAMA NEGARA', 'general', 'Negara', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banjarmasin', 'Kantor Wilayah DJKN Kalimantan Selatan Dan Tengah', 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1445, 15, '005041500632044000KD', 'PENGADILAN AGAMA BANJARBARU', 'general', 'Banjarbaru', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banjarmasin', 'Kantor Wilayah DJKN Kalimantan Selatan Dan Tengah', 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (1446, 15, '005041500690140000KD', 'PENGADILAN AGAMA BATULICIN', 'general', 'Batu Licin', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banjarmasin', 'Kantor Wilayah DJKN Kalimantan Selatan Dan Tengah', 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (1447, 16, '005041600309052000KD', 'PA TENGGARONG (04)', 'general', 'Tenggarong', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1448, 16, '005041600309053000KD', 'PENGADILAN AGAMA SAMARINDA', 'general', 'Samarinda', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1449, 16, '005041600309054000KD', 'PENGADILAN AGAMA TANAH GROGOT', 'general', 'Tanah Grogot', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1450, 16, '005041600309055000KD', 'PENGADILAN AGAMA BALIKPAPAN', 'general', 'Balikpapan', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1451, 16, '005041600309056000KD', 'PENGADILAN AGAMA TANJUNG REDEB', 'general', 'Tanjung Redep', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1452, 16, '005041600402481000KD', 'PENGADILAN TINGGI AGAMA SAMARINDA', 'tingkatbanding', 'Samarinda', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1453, 16, '005041600652081000KD', 'PENGADILAN AGAMA BONTANG', 'general', 'Bontang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bontang', 'Kantor Wilayah DJKN Kalimantan Timur Dan Utara', 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (1454, 16, '005041600652098000KD', 'PENGADILAN AGAMA SANGATTA', 'general', 'Sangatta', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bontang', 'Kantor Wilayah DJKN Kalimantan Timur Dan Utara', 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (1455, 17, '005041700309058000KD', 'PENGADILAN AGAMA MANADO', 'general', 'Manado', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1456, 17, '005041700309059000KD', 'PENGADILAN AGAMA KOTAMOBAGU', 'general', 'Kotamubagu', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1457, 17, '005041700402682000KD', 'PENGADILAN TINGGI AGAMA MANADO', 'tingkatbanding', 'Manado', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1458, 17, '005041700402702000KD', 'PENGADILAN AGAMA TONDANO', 'general', 'Tondano', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1459, 17, '005041700604752000KD', 'PENGADILAN AGAMA BITUNG', 'general', 'Bitung', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1460, 17, '005041700682172000KD', 'PENGADILAN AGAMA AMURANG', 'general', 'Amurang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Manado', 'Kantor Wilayah DJKN Sulawesi Utara, Tengah, Gorontalo Dan Maluku Utara', 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (1461, 18, '005041800309062000KD', 'PENGADILAN AGAMA PALU', 'general', 'Kodya Palu', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1462, 18, '005041800309064000KD', 'PA. POSO', 'general', 'Poso', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1463, 18, '005041800309066000KD', 'PENGADILAN AGAMA LUWUK', 'general', 'Luwuk', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1464, 18, '005041800690072000KD', 'PENGADILAN AGAMA PARIGI', 'general', 'Parigi', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Palu', 'Kantor Wilayah DJKN Sulawesi Utara, Tengah, Gorontalo Dan Maluku Utara', 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (1465, 19, '005041900309067000KD', 'PENGADILAN TINGGI AGAMA MAKASSAR', 'tingkatbanding', 'Makassar', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1466, 19, '005041900309068000KD', 'PENGADILAN AGAMA PANGKAJENE', 'general', 'Pangkajene', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1467, 19, '005041900309069000KD', 'PENGADILAN AGAMA MAROS', 'general', 'Maros', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1468, 19, '005041900309070000KD', 'UAKPB PENGADILAN AGAMA MAKASSAR 04', 'general', 'Ujung Pandang', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1469, 19, '005041900309073000KD', 'PENGADILAN AGAMA TAKALAR', 'general', 'Takalar', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1470, 19, '005041900309074000KD', 'PENGADILAN AGAMA BARRU', 'general', 'Barru', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1471, 19, '005041900309075000KD', 'PENGADILAN AGAMA SUNGGUMINASA', 'general', 'Sungguminasa', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1472, 19, '005041900309077000KD', 'PENGADILAN AGAMA SENGKANG', 'general', 'Sengkang', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1473, 19, '005041900309078000KD', 'PENGADILAN AGAMA WATANSOPPENG', 'general', 'Watan Soppeng', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1474, 19, '005041900309079000KD', 'PENGADILAN AGAMA BANTAENG', 'general', 'Bantaeng', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1475, 19, '005041900309080000KD', 'PENGADILAN AGAMA BULUKUMBA', 'general', 'Bulukumba', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1476, 19, '005041900309081000KD', 'PENGADILAN AGAMA SINJAI', 'general', 'Sinjai', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1477, 19, '005041900309082000KD', 'PENGADILAN AGAMA SELAYAR', 'general', 'Selayar', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1478, 19, '005041900309083000KD', 'PENGADILAN AGAMA PAREPARE', 'general', 'Pare Pare', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1479, 19, '005041900309084000KD', 'PA.PINRANG KLAS IB', 'general', 'Pinrang', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1480, 19, '005041900309085000KD', 'PENGADILAN AGAMA ENREKANG', 'general', 'Enrekang', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1481, 19, '005041900309087000KD', 'PA SIDRAP', 'general', 'Sidenreng', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1482, 19, '005041900309088000KD', 'PENGADILAN AGAMA PALOPO', 'general', 'Palopo', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1483, 19, '005041900309089000KD', 'PENGADILAN AGAMA MAKALE', 'general', 'Makale', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1484, 19, '005041900632052000KD', 'PENGADILAN AGAMA MASAMBA', 'general', 'Masamba', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Palopo', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (1485, 20, '005042000309094000KD', 'PENGADILAN AGAMA KOLAKA', 'general', 'Kolaka', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1486, 20, '005042000309095000KD', 'PENGADILAN AGAMA RAHA', 'general', 'Raha', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1487, 20, '005042000604773000KD', 'PENGADILAN AGAMA UNAAHA', 'general', 'Unaaha', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kendari', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1488, 20, '005042000690086000KD', 'PENGADILAN AGAMA ANDOOLO', 'general', 'Andoolo', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kendari', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (1489, 22, '005042200309105000KD', 'PENGADILAN AGAMA DENPASAR', 'general', 'Denpasar', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1490, 22, '005042200309106000KD', 'PENGADILAN AGAMA SINGARAJA', 'general', 'Singaraja', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1491, 22, '005042200402727000KD', 'PENGADILAN AGAMA BANGLI', 'general', 'Bangli', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Singaraja', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1492, 22, '005042200402733000KD', 'PENGADILAN AGAMA NEGARA', 'general', 'Negara', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banjarmasin', 'Kantor Wilayah DJKN Kalimantan Selatan Dan Tengah', 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1493, 22, '005042200402742000KD', 'PENGADILAN AGAMA KARANGASEM', 'general', 'Karangasem', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Singaraja', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1494, 22, '005042200402758000KD', 'PENGADILAN AGAMA TABANAN', 'general', 'Tabanan', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Denpasar', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1495, 22, '005042200402764000KD', 'PENGADILAN AGAMA KLUNGKUNG', 'general', 'Klungkung', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Denpasar', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1496, 22, '005042200402773000KD', 'PENGADILAN AGAMA GIANYAR', 'general', 'Gianyar', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Denpasar', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1497, 23, '005042300309107000KD', 'PENGADILAN AGAMA MATARAM', 'general', 'Mataram', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1498, 23, '005042300309109000KD', 'PENGADILAN AGAMA SUMBAWA BESAR (04)', 'general', 'Sumbawa', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1499, 23, '005042300309110000KD', 'PENGADILAN AGAMA PRAYA', 'general', 'Praya', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1500, 23, '005042300309111000KD', 'PENGADILAN AGAMA SELONG', 'general', 'Selong', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1501, 23, '005042300309114000KD', 'PENGADILAN AGAMA DOMPU (04)', 'general', 'Dompu', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1502, 23, '005042300402789000KD', 'PTA MATARAM', 'general', 'Mataram', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Mataram', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1503, 23, '005042300614728000KD', 'PA GIRI MENANG', 'general', 'Giri Menang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Mataram', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1504, 24, '005042400309115000KD', 'PENGADILAN AGAMA WAIKABUBAK', 'general', 'Waikabubak', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1505, 24, '005042400309116000KD', 'PENGADILAN AGAMA KUPANG', 'general', 'Kupang', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1506, 24, '005042400309117000KD', 'PENGADILAN AGAMA KALABAHI', 'general', 'Kalabahi', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1507, 24, '005042400309118000KD', 'Pengadilan Agama Ende', 'general', 'Ende', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1508, 24, '005042400309119000KD', 'PENGADILAN AGAMA WAINGAPU', 'general', 'Waingapu', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1509, 24, '005042400402795000KD', 'PENGADILAN AGAMA LARANTUKA', 'general', 'Larantuka', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kupang', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1510, 24, '005042400402809000KD', 'PENGADILAN AGAMA RUTENG', 'general', 'Ruteng', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kupang', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1511, 24, '005042400402815000KD', 'PENGADILAN AGAMA ATAMBUA', 'general', 'Atambua', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kupang', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1512, 24, '005042400402821000KD', 'PENGADILAN AGAMA SOE', 'general', 'Soe', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kupang', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1513, 24, '005042400402840000KD', 'PENGADILAN AGAMA KEFAMENANU', 'general', 'Kefamenanu', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kupang', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1514, 24, '005042400402846000KD', 'PENGADILAN AGAMA BAJAWA', 'general', 'Bajawa', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kupang', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1515, 24, '005042400402852000KD', 'PENGADILAN AGAMA MAUMERE', 'general', 'Maumere', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kupang', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1516, 24, '005042400576261000KD', 'PENGADILAN TINGGI AGAMA NUSA TENGGARA TIMUR', 'tingkatbanding', 'Kupang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kupang', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1517, 24, '005042400632065000KD', 'PENGADILAN AGAMA LEWOLEBA', 'general', 'Lewoleba', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kupang', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (1518, 24, '005042400682282000KD', 'PENGADILAN AGAMA LABUAN BAJO', 'general', 'Labuan Bajo', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kupang', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (1519, 25, '005042500402861000KD', 'PENGADILAN TINGGI AGAMA JAYAPURA', 'tingkatbanding', 'Jayapura', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1520, 25, '005042500402877000KD', 'PENGADILAN AGAMA JAYAPURA', 'general', 'Jayapura', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1521, 25, '005042500402892000KD', 'PENGADILAN AGAMA BIAK', 'general', 'Biak', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1522, 25, '005042500402928000KD', 'PENGADILAN AGAMA NABIRE (04)', 'general', 'Nabire', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1523, 25, '005042500402934000KD', 'PENGADILAN AGAMA WAMENA (04)', 'general', 'Wamena', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1524, 25, '005042500402943000KD', 'PENGADILAN AGAMA SERUI', 'general', 'Serui', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1525, 25, '005042500402959000KD', 'PENGADILAN AGAMA MERAUKE', 'general', 'Merauke', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1526, 25, '005042500614774000KD', 'PENGADILAN AGAMA MIMIKA', 'general', 'Mimika', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1527, 25, '005042500614781000KD', 'PENGADILAN AGAMA PANIAI (04)', 'general', 'Paniai', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1528, 25, '005042500690182000KD', 'PENGADILAN AGAMA ARSO', 'general', 'Arso', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jayapura', 'Kantor Wilayah DJKN Papua, Papua Barat Dan Maluku', 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (1529, 26, '005042600309120000KD', 'PENGADILAN AGAMA MANNA', 'general', 'Manna', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bengkulu', 'Kantor Wilayah DJKN Lampung Dan Bengkulu', 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1530, 26, '005042600309121000KD', 'PENGADILAN AGAMA CURUP', 'general', 'Curup', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bengkulu', 'Kantor Wilayah DJKN Lampung Dan Bengkulu', 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1531, 26, '005042600309122000KD', 'PENGADILAN AGAMA ARGA MAKMUR', 'general', 'Argamakmur', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bengkulu', 'Kantor Wilayah DJKN Lampung Dan Bengkulu', 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1532, 26, '005042600309123000KD', 'PENGADILAN AGAMA BENGKULU', 'general', 'Bengkulu', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bengkulu', 'Kantor Wilayah DJKN Lampung Dan Bengkulu', 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1533, 26, '005042600576275000KD', 'PENGADILAN TINGGI AGAMA BENGKULU', 'tingkatbanding', 'Bengkulu', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bengkulu', 'Kantor Wilayah DJKN Lampung Dan Bengkulu', 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1534, 26, '005042600690133000KD', 'PENGADILAN AGAMA LEBONG', 'general', 'Lebong', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bengkulu', 'Kantor Wilayah DJKN Lampung Dan Bengkulu', 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (1535, 27, '005042800309101000KD', 'PENGADILAN AGAMA TERNATE KELAS I B', 'general', 'Ternate', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1536, 27, '005042800309102000KD', 'PENGADILAN AGAMA MOROTAI', 'general', 'Morotai', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1537, 27, '005042800309103000KD', 'PENGADILAN AGAMA SOASIO', 'general', 'Soa Sio', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1538, 27, '005042800440741000KD', 'PENGADILAN TINGGI AGAMA MALUKU UTARA', 'tingkatbanding', 'Maluku Utara', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1539, 28, '005042900400798000KD', 'PENGADILAN AGAMA SERANG', 'general', 'Serang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Serang', 'Kantor Wilayah DJKN Banten', 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1540, 28, '005042900400818000KD', 'PENGADILAN AGAMA RANGKASBITUNG', 'general', 'Rangkas Bitung', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Serang', 'Kantor Wilayah DJKN Banten', 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1541, 28, '005042900400824000KD', 'PENGADILAN AGAMA TANGERANG', 'general', 'Tangerang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Tangerang II', 'Kantor Wilayah DJKN Banten', 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1542, 28, '005042900417851000KD', 'PENGADILAN AGAMA PANDEGLANG', 'general', 'Pandeglang', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Serang', 'Kantor Wilayah DJKN Banten', 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1543, 28, '005042900440713000KD', 'PENGADILAN TINGGI AGAMA BANTEN', 'tingkatbanding', 'Banten', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Serang', 'Kantor Wilayah DJKN Banten', 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1544, 28, '005042900604724000KD', 'PENGADILAN AGAMA TIGARAKSA', 'general', 'Tigaraksa', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Tangerang II', 'Kantor Wilayah DJKN Banten', 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1545, 28, '005042900652077000KD', 'PENGADILAN AGAMA CILEGON', 'general', 'Cilegon', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Serang', 'Kantor Wilayah DJKN Banten', 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (1546, 29, '005043000402319000KD', 'PENGADILAN AGAMA TANJUNGPANDAN', 'general', 'Tanjung Pandan', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pangkalpinang', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1547, 29, '005043000403093000KD', 'PENGADILAN AGAMA SUNGAILIAT', 'general', 'Sungai Liat', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pangkalpinang', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1548, 29, '005043000440729000KD', 'PENGADILAN TINGGI AGAMA KEPULAUAN BANGKA BELITUNG', 'tingkatbanding', 'Bangka Belitung', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pangkalpinang', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1549, 29, '005043000690129000KD', 'PENGADILAN AGAMA MENTOK', 'general', 'Mentok', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pangkalpinang', 'Kantor Wilayah DJKN Sumatera Selatan, Jambi Dan Bangka Belitung', 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (1550, 30, '005043100309061000KD', 'PENGADILAN AGAMA GORONTALO (04)', 'general', 'Gorontalo', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:23:58');
INSERT INTO `satkers` VALUES (1551, 30, '005043100652131000KD', 'PENGADILAN AGAMA TILAMUTA (04)', 'general', 'Tilamuta', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Gorontalo', 'Kantor Wilayah DJKN Sulawesi Utara, Tengah, Gorontalo Dan Maluku Utara', 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (1552, 30, '005043100682186000KD', 'PENGADILAN AGAMA MARISA (04)', 'general', 'Marisa', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Gorontalo', 'Kantor Wilayah DJKN Sulawesi Utara, Tengah, Gorontalo Dan Maluku Utara', 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (1553, 31, '005043200402149000KD', 'PA TANJUNGPINANG', 'general', 'Tanjung Pinang', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1554, 31, '005043200402155000KD', 'PENGADILAN AGAMA DABO SINGKEP', 'general', 'Dabo Singkep', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1555, 31, '005043200402161000KD', 'PENGADILAN AGAMA TANJUNG BALAI KARIMUN', 'general', 'Tanjung Balai Karimun', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1556, 31, '005043200402180000KD', 'PENGADILAN AGAMA TAREMPA 04', 'general', 'Tarempa', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1557, 31, '005043200547700000KD', 'PENGADILAN AGAMA BATAM', 'general', 'Batam', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1558, 31, '005043200614671000KD', 'PENGADILAN AGAMA NATUNA', 'general', 'Natuna', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1559, 32, '005043300402883000KD', 'PENGADILAN AGAMA SORONG', 'general', 'Sorong', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1560, 33, '005043400309091000KD', 'PENGADILAN AGAMA POLEWALI', 'general', 'Polewali', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1561, 33, '005043400309092000KD', 'PENGADILAN AGAMA MAJENE', 'general', 'Majene', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1562, 33, '005043400309093000KD', 'PENGADILAN AGAMA MAMUJU', 'general', 'Mamuju', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:23:59');
INSERT INTO `satkers` VALUES (1563, 34, '005043500402676000KD', 'PENGADILAN AGAMA TARAKAN', 'general', 'Tarakan', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1564, 34, '005043500417658000KD', 'Pengadilan Agama Tanjung Selor', 'general', 'Tanjung Selor', 'Badan Peradilan Agama', NULL, NULL, 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1565, 34, '005043500690175000KD', 'PENGADILAN AGAMA NUNUKAN', 'general', 'Nunukan', 'Badan Peradilan Agama', 'Kantor Pelayanan Kekayaan Negara dan Lelang Tarakan', 'Kantor Wilayah DJKN Kalimantan Timur Dan Utara', 'PA', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (1566, 1, '005050100526733000KD', 'PTUN JAKARTA', 'general', 'Jakarta', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jakarta I', 'Kantor Wilayah DJKN DKI Jakarta', 'PT', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1567, 1, '005050100663162000KD', 'PENGADILAN MILITER UTAMA', 'general', 'Jakarta', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jakarta I', 'Kantor Wilayah DJKN DKI Jakarta', 'PM', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (1568, 1, '005050100663251000KD', 'PENGADILAN MILITER TINGGI II JAKARTA (05)', 'tingkatbanding', 'Jakarta', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', 'Kantor Pelayanan Kekayaan Negara dan Lelang Jakarta I', 'Kantor Wilayah DJKN DKI Jakarta', 'PM', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (1569, 1, '005050100663268000KD', 'PENGADILAN MILITER II-08 JAKARTA (05)', 'general', 'Jakarta', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', NULL, NULL, 'PM', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (1570, 2, '005050200663272000KD', 'PENGADILAN MILITER KELAS II (05)', 'general', 'Bandung', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', NULL, NULL, 'PM', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (1571, 3, '005050300531831000KD', 'PTUN SEMARANG (05)', 'general', 'Semarang', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', 'Kantor Pelayanan Kekayaan Negara dan Lelang Semarang', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PT', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1572, 3, '005050300663289000KD', 'PENGADILAN MILITER II-10 SEMARANG', 'general', 'Semarang', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', NULL, NULL, 'PM', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (1573, 4, '005050400578802000KD', 'PENGADILAN TATA USAHA NEGARA YOGYAKARTA', 'general', 'Yogyakarta', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', 'Kantor Pelayanan Kekayaan Negara dan Lelang Yogyakarta', 'Kantor Wilayah DJKN Jawa Tengah Dan Daerah Istimewa Yogyakarta', 'PT', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1574, 4, '005050400663293000KD', 'PENGADILAN MILITER II-11 YOGYAKARTA', 'general', 'Yogyakarta', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', NULL, NULL, 'PM', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (1575, 5, '005050500663322000KD', 'PENGADILAN MILITER III-13 MADIUN (05)', 'general', 'Madiun', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', NULL, NULL, 'PM', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (1576, 7, '005050700526726000KD', 'PENGADILAN TINGGI TATA USAHA NEGARA MEDAN', 'tingkatbanding', 'Medan', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', NULL, NULL, 'PT', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1577, 7, '005050700663179000KD', 'PENGADILAN MILITER TINGGI I MEDAN', 'tingkatbanding', 'Medan', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', 'Kantor Pelayanan Kekayaan Negara dan Lelang Medan', 'Kantor Wilayah DJKN Sumatera Utara', 'PM', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (1578, 7, '005050700663200000KD', 'PENGADILAN MILITER I-02 MEDAN', 'general', 'Medan', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', NULL, NULL, 'PM', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (1579, 11, '005051100663212000KD', 'PENGADILAN MILITER I-04 PALEMBANG', 'general', 'Palembang', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', NULL, NULL, 'PM', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (1580, 12, '005051200559841000KD', 'PENGADILAN TATA USAHA NEGARA BANDAR LAMPUNG', 'general', 'Bandar Lampung', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bandar Lampung', 'Kantor Wilayah DJKN Lampung Dan Bengkulu', 'PT', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1581, 13, '005051300531852000KD', 'PTUN PONTIANAK', 'general', 'Pontianak', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', 'Kantor Pelayanan Kekayaan Negara dan Lelang Pontianak', 'Kantor Wilayah DJKN Kalimantan Barat', 'PT', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1582, 14, '005051400578844000KD', 'PENGADILAN TATA USAHA NEGARA PALANGKARAYA05', 'general', 'Palangkaraya', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', 'Kantor Pelayanan Kekayaan Negara dan Lelang Palangkaraya', 'Kantor Wilayah DJKN Kalimantan Selatan Dan Tengah', 'PT', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1583, 15, '005051500531866000KD', 'PTUN BANJARMASIN (05)', 'general', 'Banjarmasin', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', 'Kantor Pelayanan Kekayaan Negara dan Lelang Banjarmasin', 'Kantor Wilayah DJKN Kalimantan Selatan Dan Tengah', 'PT', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1584, 17, '005051700531873000KD', 'PTUN MANADO 05', 'general', 'Manado', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', NULL, NULL, 'PT', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1585, 20, '005052000578865000KD', 'PENGADILAN TUN KENDARI', 'general', 'Kendari', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', 'Kantor Pelayanan Kekayaan Negara dan Lelang Kendari', 'Kantor Wilayah DJKN Sulawesi Selatan, Tenggara Dan Barat', 'PT', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1586, 21, '005052100539118000KD', 'PTUN AMBON', 'general', 'Ambon', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', NULL, NULL, 'PT', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1587, 21, '005052100663378000KD', 'PENGADILAN MILITER AMBON', 'general', 'Ambon', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', NULL, NULL, 'PM', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (1588, 22, '005052200559862000KD', 'PENGADILAN TUN DENPASAR', 'general', 'Denpasar', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', 'Kantor Pelayanan Kekayaan Negara dan Lelang Denpasar', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PT', NULL, '2020-12-23 12:03:00', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1589, 22, '005052200663336000KD', 'PENGADILAN MILITER III-14 DENPASAR', 'general', 'Denpasar', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', NULL, NULL, 'PM', NULL, '2020-12-23 12:03:01', '2021-03-19 10:24:01');
INSERT INTO `satkers` VALUES (1590, 23, '005052300578872000KD', 'PENGADILAN TATA USAHA NEGARA MATARAM', 'general', 'Mataram', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', 'Kantor Pelayanan Kekayaan Negara dan Lelang Mataram', 'Kantor Wilayah DJKN Bali Dan Nusa Tenggara', 'PT', NULL, '2020-12-23 12:03:01', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1591, 26, '005052600578886000KD', 'PENGADILAN TUN BENGKULU', 'general', 'Bengkulu', 'Badan Peradilan Militer Dan Peradilan Tata Usaha Negara', 'Kantor Pelayanan Kekayaan Negara dan Lelang Bengkulu', 'Kantor Wilayah DJKN Lampung Dan Bengkulu', 'PT', NULL, '2020-12-23 12:03:01', '2021-03-19 10:24:00');
INSERT INTO `satkers` VALUES (1593, 28, '005012900400801000KD', 'PENGADILAN AGAMA PANDEGLANG', 'general', NULL, NULL, NULL, NULL, NULL, NULL, '2021-04-30 16:35:50', '2021-04-30 16:35:50');

SET FOREIGN_KEY_CHECKS = 1;