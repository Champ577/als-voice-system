<div class="candidate">
<!-- TABLE -->
<div class="glass-card">

  <div class="table-header">
    <h2>Candidate List</h2>

    <!-- <input
      type="text"
      class="table-search"
      placeholder="Search candidate..."
    > -->
    <!-- <button  class="btn-submit">
      <i class="fas fa-file-excel" ></i>
      CSV
    </button> -->

    <form method="get" action="download_csv.php">
      <button type="submit" class="btn-submit">
          <i class="fas fa-file-excel"></i> Export
      </button>
    </form>
  </div>

  <div class="table-wrapper">
    <table class="modern-table">
      <thead>
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Age</th>
          <th>Gender</th>
          <th>Voices</th>
          <th>Disease</th>
          <th>Description</th>
          <th>Diag. Status</th>
          <th>Diag. Year</th>
          <th>Diag. Place</th>
          <th>Diag. Type</th>
          <th>Date</th>
        </tr>
      </thead>

      <tbody>
         <?php foreach ($users as $user): ?>
        <tr>
            <td><?= ucfirst($user['name']); ?></td>
            <td><?= $user['email']; ?></td>
            <td><?= $user['phone_no']; ?></td>
            <td><?= $user['age']; ?></td>
            <td><?= $user['gender']; ?></td>
            <td>
                <a href="#" class="link" onclick="openVoiceModal(<?= (int)$user['id']; ?>)">View Voices</a>
            </td>
            <td> <span class="badge success"><?= strtoupper($user['diseases']); ?></span></td>
            <td><?= !empty($user['diseases_desc']) ? $user['diseases_desc'] : 'N/A'; ?></td>
            <td><?= !empty($user['fldDiagnosisStatus']) ? $user['fldDiagnosisStatus'] : 'N/A'; ?></td>
            <td><?= !empty($user['fldDiagnosisYear']) ? $user['fldDiagnosisYear'] : 'N/A'; ?></td>
            <td><?= !empty($user['fldDiagnosisPlace']) ? $user['fldDiagnosisPlace'] : 'N/A'; ?></td>
            <td><?= !empty($user['fldDiagnosisType']) ? $user['fldDiagnosisType'] : 'N/A'; ?></td>
            <td><?= date('d M Y', strtotime($user['created_at'])); ?></td>

        </tr>
        <?php endforeach; ?>
        <?php if (empty($users)): ?>
        <tr>
            <td colspan="6">No users found</td>
        </tr>
        <?php endif; ?>

        <!-- PHP loop rows here -->
      </tbody>
    </table>
  </div>
</div>

<!-- VOICE MODAL -->
<div class="modal" id="voiceModal">
  <div class="modal-content">

    <!-- HEADER -->
    <div class="modal-header">
      <h3>Uploaded Voice Files</h3>
      <button class="modal-close" onclick="closeVoiceModal()">
        <i class="fas fa-times"></i>
      </button>
    </div>

    <!-- BODY -->
    <div class="modal-body" id="voiceModalBody">
      <!-- Dynamic voices will be injected here -->
    </div>

  </div>
</div>
