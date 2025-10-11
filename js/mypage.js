// ===========================================
// マイページ用タブ制御スクリプト
// ===========================================

// ページロード前に body に loading クラスを追加
document.documentElement.classList.add("js");
document.body.classList.add("loading");

document.addEventListener("DOMContentLoaded", function () {
  const tabButtons = document.querySelectorAll(".tab-btn");
  const tabContents = document.querySelectorAll(".tab-content");
  const companyBtn = document.querySelector('.tab-btn[data-target="company"]');
  const recruitBtn = document.querySelector('.tab-btn[data-target="recruit"]');
  const companyTab = document.getElementById("company");
  const recruitTab = document.getElementById("recruit");

  // URLハッシュが #recruit の場合は採用情報タブを開く
  const isRecruit = window.location.hash === "#recruit";

  // 初期化：全て非表示
  tabButtons.forEach((b) => {
    b.classList.remove("active");
    b.style.background = "#ccc";
    b.style.color = "#333";
  });
  tabContents.forEach((c) => c.classList.remove("js-show"));

  if (isRecruit) {
    // 採用情報タブを表示
    recruitBtn?.classList.add("active");
    recruitBtn.style.background = "#0073aa";
    recruitBtn.style.color = "#fff";
    recruitTab?.classList.add("js-show");
  } else {
    // 企業情報タブを表示
    companyBtn?.classList.add("active");
    companyBtn.style.background = "#0073aa";
    companyBtn.style.color = "#fff";
    companyTab?.classList.add("js-show");
  }

  // タブクリック時の挙動
  tabButtons.forEach((btn) => {
    btn.addEventListener("click", () => {
      tabButtons.forEach((b) => {
        b.classList.remove("active");
        b.style.background = "#ccc";
        b.style.color = "#333";
      });
      tabContents.forEach((c) => c.classList.remove("js-show"));

      btn.classList.add("active");
      btn.style.background = "#0073aa";
      btn.style.color = "#fff";
      document.getElementById(btn.dataset.target).classList.add("js-show");
    });
  });

  // ✅ 全て準備できたら表示
  document.body.classList.remove("loading");
});



// ===========================================
// 募集フォームのスライドトグル制御スクリプト
document.addEventListener("DOMContentLoaded", function() {
  const toggleButton = document.getElementById("toggleRecruitForm");
  const formWrapper = document.getElementById("recruitFormWrapper");

  if (toggleButton && formWrapper) {
    toggleButton.addEventListener("click", function() {
      // スライドトグル
      if (formWrapper.style.display === "none" || formWrapper.style.display === "") {
        formWrapper.style.display = "block";
        formWrapper.style.maxHeight = "0";
        formWrapper.style.overflow = "hidden";
        formWrapper.style.transition = "max-height 0.5s ease";
        setTimeout(() => {
          formWrapper.style.maxHeight = formWrapper.scrollHeight + "px";
        }, 10);

        toggleButton.textContent = "− 募集フォームを閉じる";
      } else {
        formWrapper.style.maxHeight = "0";
        setTimeout(() => {
          formWrapper.style.display = "none";
        }, 500);
        toggleButton.textContent = "＋ 新規募集フォームを開く";
      }
    });
  }
});