<div class="candidate">
<!-- TABLE -->
<div class="glass-card">

  <div class="table-header">
    <h2>Enquiry List</h2>

    <!-- <input
      type="text"
      class="table-search"
      placeholder="Search candidate..."
    > -->
    <!-- <button  class="btn-submit">
      <i class="fas fa-file-excel" ></i>
      CSV
    </button> -->

    <!-- <form method="get" action="download_csv.php">
      <button type="submit" class="btn-submit">
          <i class="fas fa-file-excel"></i> Export
      </button>
    </form> -->
  </div>

  <div class="table-wrapper">
    <table class="modern-table">
      <thead>
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Phone</th>          
          <th>Message</th>
          <th>Date</th>
        </tr>
      </thead>

      <tbody>
         <?php foreach ($contactUsers as $user): ?>
        <tr>
            <td><?= ucfirst($user['fldName']); ?></td>
            <td><?= $user['fldEmail']; ?></td>
            <td><?= $user['fldContactNo']; ?></td>             
            <td><?= !empty($user['fldMessage']) ? $user['fldMessage'] : 'N/A'; ?></td>
            <td><?= date('d M Y', strtotime($user['fldSysDateTime'])); ?></td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($contactUsers)): ?>
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
