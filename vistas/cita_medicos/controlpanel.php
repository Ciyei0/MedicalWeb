<?php include '../../templates/header_medico.php'; ?>


<h1>Bienvenido a MedicalWeb</h1>
<p>Aquí puedes gestionar las citas y agenda</p>

<a href="/abc/vistas/cita_medicos/ver_citas.php?id_medico=<?php echo $id_medico; ?>" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'ver_citas.php') ? 'active' : ''; ?>">Citas</a>



<?php include '../../templates/footer.php'; ?>