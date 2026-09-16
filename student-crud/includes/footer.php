<?php
/**
 * footer.php — ส่วนท้ายของทุกหน้า
 * 
 * ปิด container, แสดง copyright, และโหลด Bootstrap JS
 */
?>
</div>
<!-- จบเนื้อหาหลัก -->

<!-- ส่วนท้ายของเว็บ -->
<footer class="text-center text-muted py-4 mt-5 border-top">
    <p>&copy; <?= date('Y') ?> ระบบจัดการนักศึกษา — โปรเจกต์เรียนรู้ PHP + MySQL</p>
</footer>

<!-- Bootstrap 5 JS จาก CDN (จำเป็นสำหรับ navbar toggle บนมือถือ) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" 
        crossorigin="anonymous"></script>
</body>
</html>
