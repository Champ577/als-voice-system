<div class="dashboard">
<!-- STATS -->
<div class="stats-grid">
  <div class="stat-card">
    <h4>Total Candidates</h4>
    <h1><?=$userCount; ?></h1>
  </div>
  <div class="stat-card accent">
    <h4>Total Voice Uploads</h4>
    <h1><?=$voiceCount; ?></h1>
  </div>
</div>

<!-- TABLE -->
<div class="glass-card">

  <div class="table-header">
    <h2>Candidate List</h2>

    <!-- <input
      type="text"
      class="table-search"
      placeholder="Search candidate..."
    > -->
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
                <a href="#" class="link" onclick="openVoiceModal(<?= $user['id']; ?>)">View Voices</a>
            </td>
            <td> <span class="badge success"><?= strtoupper($user['diseases']); ?></span></td>
            <td><?= date('d M Y', strtotime($user['created_at'])); ?></td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($users)): ?>
        <tr>
            <td colspan="6">No users found</td>
        </tr>
        <?php endif; ?>

        <!-- <tr>
          <td>
            <div class="user-cell">
              <span>Rahul Sharma</span>
            </div>
          </td>
          <td>rahul@test.com</td>
          <td>9876543210</td>
          <td>
            <a href="#" class="link" onclick="openVoiceModal()">View Voices</a>
          </td>
          <td>
            <span class="badge success">No Disability</span>
          </td>
          <td>02 Jan 2025</td>
        </tr> -->

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
