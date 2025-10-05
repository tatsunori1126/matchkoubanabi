// 確認モーダルの表示と送信処理
document.addEventListener('DOMContentLoaded', function () {
    const confirmButton = document.getElementById('confirm-button');
    const backButton = document.getElementById('back-button');
    const form = document.querySelector('.wpcf7-form');
    const modal = document.getElementById('confirmation-modal');
    const submitButton = document.getElementById('submit-button');
  
    // --- セーフガード ---
    if (!form || !confirmButton || !modal) {
      console.warn('確認モーダルの要素が見つかりません');
      return;
    }
  
    // 必須項目が揃っていないと確認ボタンを無効化
    form.addEventListener('input', function () {
      const requiredFields = Array.from(form.querySelectorAll('[required]'));
      const allValid = requiredFields.every(field => field.checkValidity());
      confirmButton.disabled = !allValid;
    });
  
    // --- 確認ボタンを押したとき ---
    confirmButton.addEventListener('click', function (e) {
      e.preventDefault();
  
      // ✅ 必須項目未入力チェック（これで確実にブロック）
      if (!form.checkValidity()) {
        form.reportValidity(); // ブラウザ標準のエラーメッセージ表示
        alert('必須項目を入力してください。');
        return;
      }
  
      // ✅ 「同意する」にチェックが入っていない場合
      const isAgreementChecked = document.querySelector('[name="acceptance"]');
      if (isAgreementChecked && !isAgreementChecked.checked) {
        alert('「同意する」にチェックを入れてください。');
        return;
      }
  
      // --- 入力値をモーダルに反映 ---
      const mapping = {
        'confirm-your-name': 'your-name',
        'confirm-company-name': 'company-name',
        'confirm-your-email': 'your-email',
        'confirm-tel-number': 'tel-number',
        'confirm-contents': 'contents'
      };
  
      Object.entries(mapping).forEach(([confirmId, inputName]) => {
        const input = form.querySelector(`[name="${inputName}"]`);
        const target = document.getElementById(confirmId);
        if (input && target) target.innerText = input.value || '未入力';
      });
  
      const radio = form.querySelector('[name="radio-kinds"]:checked');
      const radioTarget = document.getElementById('confirm-radio-kinds');
      if (radio && radioTarget) radioTarget.innerText = radio.value;
  
      const fileInput = form.querySelector('[name="your-file"]');
      const fileTarget = document.getElementById('confirm-your-file');
      if (fileInput && fileInput.files.length > 0 && fileTarget)
        fileTarget.innerText = fileInput.files[0].name;
  
      // --- モーダルを表示 ---
      modal.style.display = 'block';
      modal.style.opacity = '1';
      modal.style.visibility = 'visible';
    });
  
    // --- 戻るボタン ---
    if (backButton) {
      backButton.addEventListener('click', function () {
        modal.style.display = 'none';
      });
    }
  
    // --- モーダル内の送信ボタン ---
    if (submitButton) {
      submitButton.addEventListener('click', function (e) {
        e.preventDefault();
        form.dispatchEvent(new Event('submit', { bubbles: true }));
        modal.style.display = 'none';
      });
    }
  
    // --- 送信完了でサンクスページへリダイレクト ---
    document.addEventListener('wpcf7mailsent', function () {
      window.location.href = '/contact-complete';
    });
  });
  