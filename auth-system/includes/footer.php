</div> <!-- page-wrapper -->

<script>

/* PARTICLE SYSTEM */
(function spawnParticles() {
  const container = document.getElementById('particles');
  const COUNT = 30;
  if (!container) return;

  for (let i = 0; i < COUNT; i++) {
    const p = document.createElement('div');
    p.classList.add('particle');
    p.style.cssText = `
      left: ${Math.random() * 100}%;
      width: ${Math.random() < 0.4 ? 3 : 2}px;
      height: ${Math.random() < 0.4 ? 3 : 2}px;
      opacity: ${0.3 + Math.random() * 0.5};
      animation-duration: ${8 + Math.random() * 18}s;
      animation-delay: ${-Math.random() * 20}s;
    `;
    container.appendChild(p);
  }
})();

/* UI FUNCTIONS */
function switchPanel(target) {
  const loginPanel  = document.getElementById('panelLogin');
  const regPanel    = document.getElementById('panelRegister');

  if (!loginPanel || !regPanel) return;

  if (target === 'register') {
    loginPanel.classList.remove('active');
    regPanel.classList.add('active');
  } else {
    regPanel.classList.remove('active');
    loginPanel.classList.add('active');
  }
}

function togglePass(inputId) {
  const input = document.getElementById(inputId);
  if (!input) return;
  input.type = input.type === 'password' ? 'text' : 'password';
}

</script>

</body>
</html>