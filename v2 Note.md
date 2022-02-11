- Sewa
	- Reminder 3bulan (90hari) sebelum tanggal jatuh tempo oleh Pusat
	- Reminder 1bulan (30hari) dari tanggal persetujuan sewa pengelola barang (flow 1)


SELECT id, CONCAT_WS('-', kode_satker, kode_barang, nup) as id_asset, kode_satker, nama_barang, kode_barang, nup, nilai_perolehan, 3 as category FROM asset_tanahs
UNION ALL
SELECT id, CONCAT_WS('-', kode_satker, kode_barang, nup) as id_asset, kode_satker, nama_barang, kode_barang, nup, nilai_perolehan, 4 as category FROM asset_alat_bermotors
UNION ALL
SELECT id, CONCAT_WS('-', kode_satker, kode_barang, nup) as id_asset, kode_satker, nama_barang, kode_barang, nup, nilai_perolehan, 5 as category FROM asset_peralatan_non_tiks
UNION ALL
SELECT id, CONCAT_WS('-', kode_satker, kode_barang, nup) as id_asset, kode_satker, nama_barang, kode_barang, nup, nilai_perolehan, 6 as category FROM asset_peralatan_khusus_tiks
UNION ALL
SELECT id, CONCAT_WS('-', kode_satker, kode_barang, nup) as id_asset, kode_satker, nama_barang, kode_barang, nup, nilai_perolehan, 7 as category FROM asset_alat_berats
UNION ALL
SELECT id, CONCAT_WS('-', kode_satker, kode_barang, nup) as id_asset, kode_satker, nama_barang, kode_barang, nup, nilai_perolehan, 9 as category FROM asset_bangunan_gedungs
UNION ALL
SELECT id, CONCAT_WS('-', kode_satker, kode_barang, nup) as id_asset, kode_satker, nama_barang, kode_barang, nup, nilai_perolehan, 10 as category FROM asset_rumah_negaras
UNION ALL
SELECT id, CONCAT_WS('-', kode_satker, kode_barang, nup) as id_asset, kode_satker, nama_barang, kode_barang, nup, nilai_perolehan, 11 as category FROM asset_jalan_jembatans
UNION ALL
SELECT id, CONCAT_WS('-', kode_satker, kode_barang, nup) as id_asset, kode_satker, nama_barang, kode_barang, nup, nilai_perolehan, 12 as category FROM asset_air_irigasis
UNION ALL
SELECT id, CONCAT_WS('-', kode_satker, kode_barang, nup) as id_asset, kode_satker, nama_barang, kode_barang, nup, nilai_perolehan, 13 as category FROM asset_instalasi_jaringans
UNION ALL
SELECT id, CONCAT_WS('-', kode_satker, kode_barang, nup) as id_asset, kode_satker, nama_barang, kode_barang, nup, nilai_perolehan, 14 as category FROM asset_tetap_lainnyas
UNION ALL
SELECT id, CONCAT_WS('-', kode_satker, kode_barang, nup) as id_asset, kode_satker, nama_barang, kode_barang, nup, nilai_perolehan, 15 as category FROM asset_tak_berwujuds
UNION ALL
SELECT id, CONCAT_WS('-', kode_satker, kode_barang, nup) as id_asset, kode_satker, nama_barang, kode_barang, nup, nilai_perolehan, 16 as category FROM asset_renovasis
UNION ALL
SELECT id, CONCAT_WS('-', kode_satker, kode_barang, nup) as id_asset, kode_satker, nama_barang, kode_barang, nup, nilai_perolehan, 17 as category FROM asset_konstruksi_dalam_pengerjaans

Modul Pengembangan
1. RKBMN [DONE]
    - Upload File dengan  [DONE]
        - Tahun [DONE]
        - File [DONE]
	- Flowchart [DONE]
	- Bentuk Data [DONE]
2. Forum Diskusi [CANCEL]
	- Flowchart [DONE]
	- Bentuk Data [DONE]
3. Penjualan [DONE]
	- Kurang Memorandum [DONE]
4. Usulan Persetujuan Dokumen [DONE]
    - Kanwil DJKN (Ada dimaster data pusintek) [DONE]
5. Satker [DONE]
    - Add Column Type & Lingkungan [DONE]

Informasi 
    1. Evaluasi Type Satker, dan Lingkungan Satker [DONE]

Pertanyaan
    1. Tambahkan Kota di tiap2 satker [DONE]
    3. Bongkaran Draft Lampiran ? [DONE]
        - Revisi untuk jumlah barang lebih dari 1, [DONE]
        - Tiap2 barang menginputkan 
            - uraian dan jumlah (free text) [DONE]
            - Luas Bangunan yang dibongkar [DONE]
        - Hapus Luas Bangunan yang di bongkar di global form [DONE]
    4. Surat Persetujuan Penjualan Bongkaran [DONE]
        - kpknl [DONE]
        - kanwil_djkn [DONE]
        - dirjen [DONE]
    5. SK Sewa [DONE]
        - kpknl [DONE]
        - kanwil_djkn [DONE]
        - dirjen [DONE]
        - no_surat_kpknl = No Surat Persetujuan Sewa Pengelola Barang [DONE]
        - tanggal_surat_kpknl = Tanggal Surat Persetujuan Sewa Pengelola Barang [DONE]
        - perihal_surat_kpknl = Perihal Surat Persetujuan Sewa Pengelola Barang [DONE]
    6. Sewa Draft Lampiran ? Penambahan Barang [DONE]
        - Periode dalam bulan apa tahun? [DONE]
    7. SK Penghapusan [DONE]
        - Jenis BMN [DONE]
            - Dari Data Barang bisa banyak [DONE]
        - penawaran tertinggi_risalah lelang = Total Nilai Terjual [DONE]
        - Setempat = kpknl [DONE]
        
Flow Lapor BMN [DONE]
    - Bisa langsung Lapor per satuan Asset [DONE]
    - Lapor Per Kategori [DONE]
    - Form Laporan [DONE]
        - Jenis Lapor : Permasalahan Umum, Force Majeure [DONE]
        - Uraian [DONE]
        
        
Lapor BMN [DONE]
    - Menambahkan keterangan untuk user yang menjawab
    
- RKMBN
	- Show Denied on Admin Pusat [DONE]
	- Filter data base on Role Akses [DONE]
	- Filter Seperti di master aset [DONE]
	- Penambahan kolom alasan pada file rkmbn (File Contoh oleh MA)
	- Filter Terima & Tidak diterima DKJN Saja [DONE]
	- DJKN Disetujui, Penambahan kolom Pagu Alokasi  [DONE]
		- Ada anggaran ? [DONE]
		- Jumlah Anggaran [DONE] 
- Usulan Pengadaan [DONE]
	- Filter RKMBN by satker [DONE]
- Satker  [DONE]
	Belakang KD [DONE]
- Fitur Lapor BMN
    - Input [DONE]
        1 File PDF 10Mb [DONE]
        Foto Banyak [DONE]
    - Balas [DONE]
        1 File PDF 10Mb [DONE]
        
Pertanyaan 
    - Minus di Kuantitas & Nilai [DONE]
    - Kode Satker [DONE]
    
    
    
27 Mei 2021
- Menambah keterangan extension dan max size di tiap2 upload file [DONE]
- Penjualan BMN
	- Barang tidak bisa di pilih jika sudah pernah di usulkan
- Typo Pada Draft Lampiran Excel
- Sewa
	- Penandatanganan Persetujuan Sewa Pengelola Barang = freetext [DONE]

- Pengadaan - Renovasi
	- Biaya pindah kiri semua [DONE]

- Pengelolaan
	- Export Data Excel Pusat

- Pengajuan Usulan Pengadaan
	- Pengadaan Tanah Baru (3 Penawaran) [DONE]
	- Perluasan (1 Penawaran) [DONE]
	- Penambahan Input Luas Tanah (m2) Mandatori [DONE]