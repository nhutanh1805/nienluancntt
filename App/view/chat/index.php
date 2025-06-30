<?php $this->layout("layouts/default", ["title" => "Chat Chung"]) ?>

<?php $this->start("page_specific_css") ?>
<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>
  #chat-container {
    max-width: 800px;
    height: 80vh;
    margin: 0 auto;
    display: flex;
    flex-direction: column;
    background: #f0f2f5;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
  }

  #chat-header {
    background-color: #0084ff;
    color: white;
    padding: 1rem;
    font-size: 1.25rem;
    font-weight: bold;
    text-align: center;
  }

  #chat-box {
    flex: 1;
    padding: 1rem;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
    gap: 1rem;
    background-color: #e5ddd5;
  }

  .message-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
  }

  .message-item {
    display: flex;
    align-items: flex-end;
    max-width: 70%;
  }

  .message-item.other {
    flex-direction: row;
    align-self: flex-start;
  }

  .message-item.self {
    flex-direction: row-reverse;
    align-self: flex-end;
  }

  .message-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background-color: #adb5bd;
    background-size: cover;
    background-position: center;
    margin: 0 0.5rem;
    flex-shrink: 0;
  }

  .message-content-wrapper {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
  }

  .message-item.self .message-content-wrapper {
    align-items: flex-end;
  }

  .message-sender {
    font-size: 0.8rem;
    font-weight: 600;
    margin-bottom: 0.2rem;
    color: #333;
    display: flex;
    align-items: center;
  }

  .message-sender form {
    margin-left: 0.5rem;
  }

  .message-content {
    background-color: white;
    padding: 0.6rem 1rem;
    border-radius: 18px;
    font-size: 0.95rem;
    word-wrap: break-word;
    position: relative;
    max-width: 100%;
    transition: transform 0.15s ease, background-color 0.2s ease;
  }

  .message-content:hover {
    background-color: #e2e6ea;
    transform: scale(1.01);
    cursor: default;
  }

  .message-item.self .message-content {
    background-color: #0084ff;
    color: white;
    border-bottom-right-radius: 0;
  }

  .message-item.self .message-content:hover {
    background-color: #0073e6;
  }

  .message-time {
    font-size: 0.7rem;
    color: #666;
    margin-top: 0.25rem;
    text-align: right;
  }

  #chat-footer {
    padding: 0.75rem 1rem;
    background: #fff;
    border-top: 1px solid #ccc;
  }

  #chat-message-input {
    width: 100%;
    border: none;
    resize: none;
    border-radius: 20px;
    padding: 0.5rem 1rem;
    font-size: 1rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    outline: none;
  }

  #chat-message-input:focus {
    box-shadow: 0 0 0 2px rgba(0,132,255,0.3);
  }

  #chat-send-btn {
    border-radius: 50%;
    width: 44px;
    height: 44px;
    font-size: 1.25rem;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-left: 0.75rem;
  }

  /* nút thu hồi tin nhắn */
  .revoke-btn {
    background: transparent;
    border: none;
    color: #dc3545;
    cursor: pointer;
    font-size: 1.2rem;
    padding: 0;
    display: flex;
    align-items: center;
  }

  .revoke-btn:hover {
    color: #a71d2a;
  }
</style>
<?php $this->stop() ?>

<?php $this->start("page") ?>
<div id="chat-container">
  <div id="chat-header">
    💬 Chat Với Mọi Người
  </div>

  <div id="chat-box">
    <?php if (empty($messages)): ?>
      <p class="text-center text-muted mt-4">Chưa có tin nhắn nào.</p>
    <?php else: ?>
      <ul class="message-list">
        <?php foreach ($messages as $msg): ?>
          <?php 
            $isSelf = isset($userId) && $userId == $msg['sender_id'];
            $name = urlencode($msg['sender_name']);
            $avatarUrl = !empty($msg['avatar_url']) ? $msg['avatar_url'] : "https://ui-avatars.com/api/?name=$name&background=random&rounded=true&size=64";
          ?>
          <li class="message-item <?= $isSelf ? 'self' : 'other' ?>">
            <div class="message-avatar" style="background-image: url('<?= htmlspecialchars($avatarUrl) ?>');"></div>
            <div class="message-content-wrapper">
              <div class="message-sender">
                <i class="bi bi-person-circle me-1"></i>
                <?= htmlspecialchars($msg['sender_name']) ?>

                <?php if ($isSelf): ?>
                  <form action="/chat/revoke" method="POST" onsubmit="return confirm('Bạn có chắc muốn thu hồi tin nhắn này?');" title="Thu hồi tin nhắn" style="display:inline-block;">
                    <input type="hidden" name="message_id" value="<?= $msg['id'] ?>">
                    <button type="submit" class="revoke-btn" aria-label="Thu hồi tin nhắn">
                      <i class="bi bi-x-circle-fill"></i>
                    </button>
                  </form>
                <?php endif; ?>
              </div>
              <div class="message-content shadow-sm">
                <i class="bi bi-chat-left-text me-2 text-primary"></i>
                <?= nl2br(htmlspecialchars($msg['message'])) ?>
              </div>
              <div class="message-time">
                <i class="bi bi-clock me-1"></i>
                <?= date("H:i d/m/Y", strtotime($msg['sent_at'])) ?>
              </div>
            </div>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
  </div>

  <div id="chat-footer" class="d-flex align-items-center">
    <form action="/chat/send" method="POST" class="d-flex w-100" autocomplete="off">
      <textarea id="chat-message-input" name="message" placeholder="Aa" rows="1" required oninput="autoGrow(this)"></textarea>
      <button type="submit" id="chat-send-btn" class="btn btn-primary" title="Gửi tin nhắn">
        <i class="bi bi-send-fill"></i>
      </button>
    </form>
  </div>
</div>
<?php $this->stop() ?>

<?php $this->start("page_specific_js") ?>
<script>
  const chatBox = document.getElementById('chat-box');
  if (chatBox) chatBox.scrollTop = chatBox.scrollHeight;

  function autoGrow(textarea) {
    textarea.style.height = 'auto';
    textarea.style.height = (textarea.scrollHeight) + 'px';
  }
</script>
<?php $this->stop() ?>
