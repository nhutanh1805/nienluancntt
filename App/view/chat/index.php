<?php if (!empty($_SESSION['error'])): ?>
  <div class="alert alert-danger">
    <?= htmlspecialchars($_SESSION['error']) ?>
  </div>
  <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<div class="container mt-3">
  <h2>Chat chung</h2>

  <div id="chat-box" style="height: 400px; overflow-y: auto; border: 1px solid #ccc; padding: 10px; background: #f9f9f9;">
    <?php foreach ($messages as $msg): ?>
      <div class="mb-2">
        <b><?= htmlspecialchars($msg['sender_name']) ?></b>:
        <span><?= nl2br(htmlspecialchars($msg['message'])) ?></span>
        <br>
        <small class="text-muted"><?= $msg['sent_at'] ?></small>
      </div>
    <?php endforeach; ?>
  </div>

  <form action="/chat/send" method="POST" class="mt-3 d-flex" autocomplete="off">
    <input
      type="text"
      name="message"
      class="form-control me-2"
      placeholder="Nhập tin nhắn..."
      required
      autofocus
    />
    <button type="submit" class="btn btn-primary">Gửi</button>
  </form>
</div>

<script>
  // Tự cuộn xuống cuối chat khi tải trang
  const chatBox = document.getElementById('chat-box');
  chatBox.scrollTop = chatBox.scrollHeight;
</script>
