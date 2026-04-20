<!DOCTYPE html>
<!-- saved from url=(0050)file:///C:/Users/M4TRIX/Downloads/auth-system.html -->
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>NEXUS — Authentication</title>
<style>
/* ============================================
   CSS VARIABLES & RESET
   ============================================ */
:root {
  --bg-deep:        #050810;
  --bg-mid:         #080d1a;
  --glass-bg:       rgba(12, 20, 40, 0.55);
  --glass-border:   rgba(100, 160, 255, 0.12);
  --glass-shine:    rgba(120, 180, 255, 0.06);

  --accent-blue:    #3d8bff;
  --accent-cyan:    #00d4ff;
  --accent-purple:  #9b5de5;
  --accent-violet:  #6e4aff;
  --glow-blue:      rgba(61, 139, 255, 0.35);
  --glow-cyan:      rgba(0, 212, 255, 0.25);
  --glow-purple:    rgba(155, 93, 229, 0.3);

  --text-primary:   #e8eeff;
  --text-secondary: rgba(180, 200, 255, 0.6);
  --text-muted:     rgba(120, 150, 200, 0.45);

  --input-bg:       rgba(8, 16, 36, 0.7);
  --input-border:   rgba(80, 130, 220, 0.18);
  --input-focus:    rgba(61, 139, 255, 0.5);

  --error:          #ff4d6d;
  --success:        #00e5a0;
  --warning:        #ffb340;

  --radius-card:    24px;
  --radius-input:   12px;
  --radius-btn:     12px;

  --font-display:   'Syne', sans-serif;
  --font-body:      'DM Sans', sans-serif;

  --transition:     all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

html, body {
  height: 100%;
  font-family: var(--font-body);
  background: var(--bg-deep);
  color: var(--text-primary);
  overflow: hidden;
}

/* ============================================
   ANIMATED BACKGROUND
   ============================================ */
.scene {
  position: fixed;
  inset: 0;
  z-index: 0;
  overflow: hidden;
}

/* Layered gradient mesh */
.scene::before {
  content: '';
  position: absolute;
  inset: 0;
  background:
    radial-gradient(ellipse 80% 60% at 20% 10%, rgba(110, 74, 255, 0.18) 0%, transparent 60%),
    radial-gradient(ellipse 60% 50% at 80% 80%, rgba(0, 212, 255, 0.12) 0%, transparent 55%),
    radial-gradient(ellipse 50% 40% at 60% 20%, rgba(61, 139, 255, 0.1) 0%, transparent 50%),
    radial-gradient(ellipse 40% 60% at 10% 70%, rgba(155, 93, 229, 0.08) 0%, transparent 50%),
    linear-gradient(160deg, #050810 0%, #080d1a 50%, #06091a 100%);
}

/* Floating orbs */
.orb {
  position: absolute;
  border-radius: 50%;
  filter: blur(80px);
  animation: floatOrb linear infinite;
  pointer-events: none;
}
.orb-1 {
  width: 520px; height: 520px;
  background: radial-gradient(circle, rgba(110, 74, 255, 0.22), transparent 70%);
  top: -180px; left: -100px;
  animation-duration: 28s;
}
.orb-2 {
  width: 400px; height: 400px;
  background: radial-gradient(circle, rgba(0, 212, 255, 0.18), transparent 70%);
  bottom: -120px; right: -80px;
  animation-duration: 22s;
  animation-delay: -8s;
}
.orb-3 {
  width: 280px; height: 280px;
  background: radial-gradient(circle, rgba(61, 139, 255, 0.2), transparent 70%);
  top: 45%; left: 55%;
  animation-duration: 18s;
  animation-delay: -14s;
}
.orb-4 {
  width: 200px; height: 200px;
  background: radial-gradient(circle, rgba(155, 93, 229, 0.2), transparent 70%);
  top: 20%; right: 20%;
  animation-duration: 24s;
  animation-delay: -5s;
}

@keyframes floatOrb {
  0%   { transform: translate(0, 0) scale(1); }
  25%  { transform: translate(30px, -40px) scale(1.05); }
  50%  { transform: translate(-20px, 30px) scale(0.95); }
  75%  { transform: translate(40px, 20px) scale(1.03); }
  100% { transform: translate(0, 0) scale(1); }
}

/* Grid lines overlay */
.grid-lines {
  position: absolute;
  inset: 0;
  background-image:
    linear-gradient(rgba(61,139,255,0.04) 1px, transparent 1px),
    linear-gradient(90deg, rgba(61,139,255,0.04) 1px, transparent 1px);
  background-size: 60px 60px;
  mask-image: radial-gradient(ellipse 80% 80% at 50% 50%, black 30%, transparent 100%);
}

/* Particle dots */
.particles {
  position: absolute;
  inset: 0;
  overflow: hidden;
}
.particle {
  position: absolute;
  width: 2px; height: 2px;
  background: rgba(100, 180, 255, 0.6);
  border-radius: 50%;
  animation: particleDrift linear infinite;
}
@keyframes particleDrift {
  0%   { transform: translateY(100vh) scale(0); opacity: 0; }
  10%  { opacity: 1; }
  90%  { opacity: 0.5; }
  100% { transform: translateY(-20px) scale(1); opacity: 0; }
}

/* ============================================
   LAYOUT
   ============================================ */
.page-wrapper {
  position: relative;
  z-index: 10;
  display: flex;
  align-items: center;
  justify-content: center;
  min-height: 100vh;
  padding: 20px;
}

/* ============================================
   CARD
   ============================================ */
.auth-card {
  width: 100%;
  max-width: 460px;
  background: var(--glass-bg);
  border: 1px solid var(--glass-border);
  border-radius: var(--radius-card);
  backdrop-filter: blur(28px) saturate(160%);
  -webkit-backdrop-filter: blur(28px) saturate(160%);
  box-shadow:
    0 0 0 1px rgba(100,160,255,0.06) inset,
    0 0 80px rgba(61,139,255,0.08),
    0 40px 120px rgba(0,0,0,0.6),
    0 8px 32px rgba(0,0,0,0.4);
  padding: 48px 44px 44px;
  animation: cardReveal 0.7s cubic-bezier(0.22, 1, 0.36, 1) both;
  position: relative;
  overflow: hidden;
}

/* Card inner shimmer */
.auth-card::before {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 1px;
  background: linear-gradient(90deg, transparent 0%, rgba(120,180,255,0.5) 40%, rgba(200,140,255,0.4) 60%, transparent 100%);
}
.auth-card::after {
  content: '';
  position: absolute;
  top: 0; left: -100%;
  width: 60%;
  height: 100%;
  background: linear-gradient(105deg, transparent 40%, var(--glass-shine) 50%, transparent 60%);
  animation: shimmer 6s ease-in-out infinite;
  pointer-events: none;
}
@keyframes shimmer {
  0%, 100% { left: -100%; }
  50% { left: 140%; }
}

@keyframes cardReveal {
  from {
    opacity: 0;
    transform: translateY(30px) scale(0.97);
    filter: blur(4px);
  }
  to {
    opacity: 1;
    transform: translateY(0) scale(1);
    filter: blur(0);
  }
}

/* ============================================
   BRAND HEADER
   ============================================ */
.brand {
  text-align: center;
  margin-bottom: 36px;
}

.brand-logo {
  display: inline-flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 20px;
}

.logo-icon {
  width: 36px; height: 36px;
  position: relative;
}
.logo-icon svg {
  width: 100%; height: 100%;
  filter: drop-shadow(0 0 8px var(--accent-cyan));
}

.brand-name {
  font-family: var(--font-display);
  font-size: 22px;
  font-weight: 800;
  letter-spacing: 0.15em;
  background: linear-gradient(135deg, #ffffff 0%, var(--accent-cyan) 50%, var(--accent-blue) 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

.auth-heading {
  font-family: var(--font-display);
  font-size: 26px;
  font-weight: 700;
  color: var(--text-primary);
  line-height: 1.2;
  margin-bottom: 6px;
}
.auth-subheading {
  font-size: 14px;
  color: var(--text-secondary);
  font-weight: 300;
  letter-spacing: 0.01em;
}

/* ============================================
   PANEL SWITCHER (login / register)
   ============================================ */
.panel { display: none; }
.panel.active {
  display: block;
  animation: panelIn 0.4s cubic-bezier(0.22,1,0.36,1) both;
}
@keyframes panelIn {
  from { opacity: 0; transform: translateX(16px); }
  to   { opacity: 1; transform: translateX(0); }
}

/* ============================================
   FORM ELEMENTS
   ============================================ */
.form-group {
  margin-bottom: 18px;
  position: relative;
}

.form-label {
  display: block;
  font-size: 11.5px;
  font-weight: 500;
  letter-spacing: 0.1em;
  text-transform: uppercase;
  color: var(--text-secondary);
  margin-bottom: 8px;
}

.input-wrapper {
  position: relative;
}

.input-icon {
  position: absolute;
  left: 16px;
  top: 50%;
  transform: translateY(-50%);
  color: var(--text-muted);
  transition: var(--transition);
  pointer-events: none;
  line-height: 0;
}

.form-input {
  width: 100%;
  background: var(--input-bg);
  border: 1px solid var(--input-border);
  border-radius: var(--radius-input);
  color: var(--text-primary);
  font-family: var(--font-body);
  font-size: 14.5px;
  font-weight: 400;
  padding: 14px 16px 14px 44px;
  outline: none;
  transition: var(--transition);
  letter-spacing: 0.01em;
  -webkit-appearance: none;
}

.form-input::placeholder {
  color: var(--text-muted);
  font-size: 13.5px;
}

/* Focus state */
.form-input:focus {
  border-color: var(--accent-blue);
  background: rgba(10, 20, 50, 0.8);
  box-shadow:
    0 0 0 3px rgba(61, 139, 255, 0.14),
    0 0 20px rgba(61, 139, 255, 0.1),
    inset 0 1px 0 rgba(120,180,255,0.08);
}

.form-input:focus + .input-focus-line { transform: scaleX(1); }
.input-focus-line {
  position: absolute;
  bottom: 0; left: 10%; right: 10%;
  height: 2px;
  background: linear-gradient(90deg, var(--accent-violet), var(--accent-blue), var(--accent-cyan));
  border-radius: 2px;
  transform: scaleX(0);
  transition: transform 0.3s cubic-bezier(0.22,1,0.36,1);
  box-shadow: 0 0 10px var(--accent-cyan);
}

/* Icon glow on focus */
.input-wrapper:focus-within .input-icon {
  color: var(--accent-blue);
  filter: drop-shadow(0 0 6px var(--accent-blue));
}

/* Password toggle */
.toggle-pass {
  position: absolute;
  right: 14px;
  top: 50%;
  transform: translateY(-50%);
  background: none;
  border: none;
  cursor: pointer;
  color: var(--text-muted);
  padding: 4px;
  line-height: 0;
  transition: var(--transition);
  z-index: 2;
}
.toggle-pass:hover { color: var(--accent-blue); }

/* Validation feedback */
.input-feedback {
  display: flex;
  align-items: center;
  gap: 5px;
  margin-top: 6px;
  font-size: 11.5px;
  font-weight: 400;
  min-height: 16px;
  opacity: 0;
  transition: opacity 0.2s;
}
.input-feedback.visible { opacity: 1; }
.input-feedback.error   { color: var(--error); }
.input-feedback.success { color: var(--success); }

/* ============================================
   PASSWORD STRENGTH BAR
   ============================================ */
.strength-bar-container {
  margin-top: 10px;
  display: none;
}
.strength-bar-container.show { display: block; }
.strength-label-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 6px;
}
.strength-label {
  font-size: 11px;
  letter-spacing: 0.08em;
  text-transform: uppercase;
  color: var(--text-muted);
}
.strength-text {
  font-size: 11px;
  font-weight: 600;
  letter-spacing: 0.05em;
  text-transform: uppercase;
  transition: color 0.3s;
}
.strength-track {
  display: flex;
  gap: 4px;
  height: 3px;
}
.strength-segment {
  flex: 1;
  border-radius: 2px;
  background: rgba(255,255,255,0.07);
  transition: background 0.4s cubic-bezier(0.4,0,0.2,1), box-shadow 0.4s;
}
.strength-segment.active-weak    { background: var(--error); box-shadow: 0 0 6px var(--error); }
.strength-segment.active-fair    { background: var(--warning); box-shadow: 0 0 6px var(--warning); }
.strength-segment.active-good    { background: var(--accent-blue); box-shadow: 0 0 6px var(--accent-blue); }
.strength-segment.active-strong  { background: var(--success); box-shadow: 0 0 6px var(--success); }

/* ============================================
   FORGOT PASSWORD LINK
   ============================================ */
.form-row-inline {
  display: flex;
  justify-content: flex-end;
  margin-top: -8px;
  margin-bottom: 4px;
}
.link-subtle {
  font-size: 12px;
  color: var(--text-secondary);
  text-decoration: none;
  transition: color 0.2s;
  letter-spacing: 0.01em;
}
.link-subtle:hover { color: var(--accent-cyan); }

/* ============================================
   PRIMARY BUTTON
   ============================================ */
.btn-primary {
  width: 100%;
  padding: 15px 24px;
  border: none;
  border-radius: var(--radius-btn);
  cursor: pointer;
  font-family: var(--font-display);
  font-size: 14px;
  font-weight: 700;
  letter-spacing: 0.12em;
  text-transform: uppercase;
  color: #fff;
  background: linear-gradient(135deg, var(--accent-violet) 0%, var(--accent-blue) 55%, var(--accent-cyan) 100%);
  background-size: 200% 200%;
  background-position: 0% 50%;
  position: relative;
  overflow: hidden;
  transition:
    background-position 0.5s ease,
    box-shadow 0.3s ease,
    transform 0.2s ease;
  margin-top: 8px;
}

.btn-primary::before {
  content: '';
  position: absolute;
  inset: 0;
  background: linear-gradient(105deg, transparent 30%, rgba(255,255,255,0.15) 50%, transparent 70%);
  transform: translateX(-100%);
  transition: transform 0.5s ease;
}
.btn-primary:hover::before { transform: translateX(100%); }

.btn-primary:hover {
  background-position: 100% 50%;
  box-shadow:
    0 0 30px rgba(61,139,255,0.45),
    0 0 60px rgba(110,74,255,0.2),
    0 8px 24px rgba(0,0,0,0.3);
  transform: translateY(-2px);
}
.btn-primary:active { transform: translateY(0) scale(0.99); }

.btn-primary .btn-text { position: relative; z-index: 1; }

/* Spinner in button */
.btn-spinner {
  display: none;
  width: 18px; height: 18px;
  border: 2px solid rgba(255,255,255,0.3);
  border-top-color: #fff;
  border-radius: 50%;
  animation: spin 0.7s linear infinite;
  position: absolute;
  top: 50%; left: 50%;
  transform: translate(-50%,-50%);
}
@keyframes spin { to { transform: translate(-50%,-50%) rotate(360deg); } }

/* ============================================
   DIVIDER
   ============================================ */
.divider {
  display: flex;
  align-items: center;
  gap: 12px;
  margin: 24px 0;
}
.divider-line {
  flex: 1;
  height: 1px;
  background: linear-gradient(90deg, transparent, var(--glass-border), transparent);
}
.divider-text {
  font-size: 11px;
  color: var(--text-muted);
  letter-spacing: 0.1em;
  text-transform: uppercase;
  white-space: nowrap;
}

/* ============================================
   TOGGLE LINK (switch panels)
   ============================================ */
.toggle-panel {
  text-align: center;
  font-size: 13px;
  color: var(--text-secondary);
  margin-top: 24px;
  line-height: 1.5;
}
.toggle-panel button {
  background: none;
  border: none;
  cursor: pointer;
  color: var(--accent-cyan);
  font-family: var(--font-body);
  font-size: 13px;
  font-weight: 500;
  text-decoration: none;
  border-bottom: 1px solid transparent;
  padding-bottom: 1px;
  transition: var(--transition);
}
.toggle-panel button:hover {
  color: #fff;
  border-bottom-color: var(--accent-cyan);
  text-shadow: 0 0 10px var(--glow-cyan);
}

/* ============================================
   SOCIAL LOGIN OPTION
   ============================================ */
.btn-social {
  width: 100%;
  padding: 13px 20px;
  background: rgba(255,255,255,0.04);
  border: 1px solid rgba(255,255,255,0.08);
  border-radius: var(--radius-btn);
  cursor: pointer;
  font-family: var(--font-body);
  font-size: 13.5px;
  font-weight: 400;
  color: var(--text-secondary);
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  transition: var(--transition);
  letter-spacing: 0.01em;
}
.btn-social:hover {
  background: rgba(255,255,255,0.07);
  border-color: rgba(100,160,255,0.2);
  color: var(--text-primary);
  box-shadow: 0 0 20px rgba(61,139,255,0.08);
}

.social-row {
  display: flex;
  gap: 10px;
}
.social-row .btn-social { padding: 12px; flex: 1; }

/* ============================================
   TERMS
   ============================================ */
.terms-text {
  text-align: center;
  font-size: 11px;
  color: var(--text-muted);
  margin-top: 20px;
  line-height: 1.6;
}
.terms-text a {
  color: var(--text-secondary);
  text-decoration: underline;
  text-decoration-color: rgba(120,150,200,0.3);
}

/* ============================================
   INPUT ERROR STATE
   ============================================ */
.form-input.invalid {
  border-color: rgba(255, 77, 109, 0.4);
  box-shadow: 0 0 0 3px rgba(255,77,109,0.08);
}
.form-input.valid {
  border-color: rgba(0, 229, 160, 0.3);
}

/* ============================================
   RESPONSIVE
   ============================================ */
@media (max-width: 520px) {
  .auth-card {
    padding: 36px 24px 30px;
    border-radius: 20px;
  }
  .auth-heading { font-size: 22px; }
}

@media (max-height: 720px) {
  .auth-card { padding: 32px 40px 32px; }
  .brand { margin-bottom: 24px; }
  .form-group { margin-bottom: 14px; }
}

/* ============================================
   SCROLL WITHIN CARD when needed
   ============================================ */
.auth-card {
  max-height: 96vh;
  overflow-y: auto;
  scrollbar-width: none;
}
.auth-card::-webkit-scrollbar { display: none; }
</style>
</head>
<body>

<!-- ===== BACKGROUND SCENE ===== -->
<div class="scene">
  <div class="orb orb-1"></div>
  <div class="orb orb-2"></div>
  <div class="orb orb-3"></div>
  <div class="orb orb-4"></div>
  <div class="grid-lines"></div>
  <div class="particles" id="particles"><div class="particle" style="left: 49.9069%; width: 2px; height: 3px; opacity: 0.678352; animation-duration: 21.0067s; animation-delay: -6.85313s;"></div><div class="particle" style="left: 27.2393%; width: 2px; height: 2px; opacity: 0.61582; animation-duration: 12.3947s; animation-delay: -1.50767s;"></div><div class="particle" style="left: 46.3062%; width: 3px; height: 3px; opacity: 0.704869; animation-duration: 23.2852s; animation-delay: -13.308s;"></div><div class="particle" style="left: 39.6321%; width: 2px; height: 2px; opacity: 0.694047; animation-duration: 8.66531s; animation-delay: -10.5571s;"></div><div class="particle" style="left: 89.6437%; width: 3px; height: 3px; opacity: 0.62941; animation-duration: 19.1943s; animation-delay: -15.0467s;"></div><div class="particle" style="left: 87.2637%; width: 2px; height: 2px; opacity: 0.751957; animation-duration: 20.7099s; animation-delay: -3.00919s;"></div><div class="particle" style="left: 90.6973%; width: 2px; height: 3px; opacity: 0.423469; animation-duration: 12.8162s; animation-delay: -5.47205s;"></div><div class="particle" style="left: 84.2937%; width: 3px; height: 2px; opacity: 0.391405; animation-duration: 13.8428s; animation-delay: -1.50357s;"></div><div class="particle" style="left: 61.2835%; width: 3px; height: 2px; opacity: 0.349518; animation-duration: 17.1594s; animation-delay: -6.96561s;"></div><div class="particle" style="left: 96.0552%; width: 3px; height: 2px; opacity: 0.738716; animation-duration: 16.2014s; animation-delay: -3.95877s;"></div><div class="particle" style="left: 36.8898%; width: 2px; height: 3px; opacity: 0.795877; animation-duration: 19.8906s; animation-delay: -13.688s;"></div><div class="particle" style="left: 40.1183%; width: 2px; height: 3px; opacity: 0.773675; animation-duration: 8.4596s; animation-delay: -2.93991s;"></div><div class="particle" style="left: 5.48258%; width: 3px; height: 2px; opacity: 0.489081; animation-duration: 25.6708s; animation-delay: -10.2466s;"></div><div class="particle" style="left: 77.8242%; width: 2px; height: 2px; opacity: 0.793155; animation-duration: 18.7245s; animation-delay: -8.60771s;"></div><div class="particle" style="left: 13.7839%; width: 3px; height: 3px; opacity: 0.410537; animation-duration: 21.3596s; animation-delay: -15.5646s;"></div><div class="particle" style="left: 61.5107%; width: 3px; height: 2px; opacity: 0.517636; animation-duration: 25.203s; animation-delay: -5.84577s;"></div><div class="particle" style="left: 45.6503%; width: 2px; height: 2px; opacity: 0.333164; animation-duration: 15.5072s; animation-delay: -19.7097s;"></div><div class="particle" style="left: 69.2767%; width: 2px; height: 2px; opacity: 0.699288; animation-duration: 16.0676s; animation-delay: -0.749005s;"></div><div class="particle" style="left: 92.1444%; width: 3px; height: 2px; opacity: 0.649803; animation-duration: 18.6656s; animation-delay: -9.03417s;"></div><div class="particle" style="left: 89.7635%; width: 3px; height: 2px; opacity: 0.370995; animation-duration: 18.9861s; animation-delay: -10.5123s;"></div><div class="particle" style="left: 49.3404%; width: 2px; height: 2px; opacity: 0.407003; animation-duration: 25.2643s; animation-delay: -18.7922s;"></div><div class="particle" style="left: 31.1929%; width: 3px; height: 2px; opacity: 0.457297; animation-duration: 22.5071s; animation-delay: -5.97486s;"></div><div class="particle" style="left: 16.5378%; width: 3px; height: 2px; opacity: 0.453987; animation-duration: 12.0649s; animation-delay: -7.69022s;"></div><div class="particle" style="left: 12.0622%; width: 2px; height: 3px; opacity: 0.682412; animation-duration: 10.8222s; animation-delay: -11.118s;"></div><div class="particle" style="left: 86.2397%; width: 3px; height: 3px; opacity: 0.316485; animation-duration: 20.1042s; animation-delay: -18.575s;"></div><div class="particle" style="left: 93.1172%; width: 3px; height: 2px; opacity: 0.369947; animation-duration: 21.4974s; animation-delay: -9.60163s;"></div><div class="particle" style="left: 17.633%; width: 2px; height: 3px; opacity: 0.338757; animation-duration: 13.7837s; animation-delay: -9.23337s;"></div><div class="particle" style="left: 30.0866%; width: 3px; height: 2px; opacity: 0.62905; animation-duration: 19.0596s; animation-delay: -11.6839s;"></div><div class="particle" style="left: 70.9446%; width: 2px; height: 2px; opacity: 0.422216; animation-duration: 15.5165s; animation-delay: -2.79079s;"></div><div class="particle" style="left: 49.8644%; width: 2px; height: 2px; opacity: 0.724074; animation-duration: 12.1052s; animation-delay: -5.22953s;"></div></div>
</div>

<!-- ===== AUTH CARD ===== -->
<div class="page-wrapper">
  <div class="auth-card" id="authCard">

    <!-- Brand -->
    <div class="brand">
      <div class="brand-logo">
        <div class="logo-icon">
          <!-- Geometric hexagon logo -->
          <svg viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M18 2L33 10.5V25.5L18 34L3 25.5V10.5L18 2Z" stroke="url(#logoGrad)" stroke-width="1.5" fill="none"></path>
            <path d="M18 8L27 13V23L18 28L9 23V13L18 8Z" fill="url(#logoFill)" opacity="0.4"></path>
            <circle cx="18" cy="18" r="4" fill="url(#logoGrad2)"></circle>
            <defs>
              <lineargradient id="logoGrad" x1="3" y1="2" x2="33" y2="34">
                <stop offset="0%" stop-color="#6e4aff"></stop>
                <stop offset="50%" stop-color="#3d8bff"></stop>
                <stop offset="100%" stop-color="#00d4ff"></stop>
              </lineargradient>
              <lineargradient id="logoFill" x1="9" y1="8" x2="27" y2="28">
                <stop offset="0%" stop-color="#6e4aff"></stop>
                <stop offset="100%" stop-color="#00d4ff"></stop>
              </lineargradient>
              <radialgradient id="logoGrad2">
                <stop offset="0%" stop-color="#00d4ff"></stop>
                <stop offset="100%" stop-color="#3d8bff"></stop>
              </radialgradient>
            </defs>
          </svg>
        </div>
        <span class="brand-name">Ovir Dukan</span>
      </div>

      <!-- Heading changes per panel -->
      <h1 class="auth-heading" id="cardHeading">Create account</h1>
      <p class="auth-subheading" id="cardSubheading">Join the next generation of shopping</p>
    </div>

    <!-- ===================== LOGIN PANEL ===================== -->
    <div class="panel" id="panelLogin">

      <!-- Social login -->
      <div class="social-row">
        <button class="btn-social" aria-label="Continue with Google">
          <!-- Google icon -->
          <svg width="18" height="18" viewBox="0 0 18 18"><path fill="#4285F4" d="M17.64 9.2c0-.637-.057-1.251-.164-1.84H9v3.481h4.844a4.14 4.14 0 01-1.796 2.716v2.259h2.908c1.702-1.567 2.684-3.875 2.684-6.615z"></path><path fill="#34A853" d="M9 18c2.43 0 4.467-.806 5.956-2.18l-2.908-2.259c-.806.54-1.837.86-3.048.86-2.344 0-4.328-1.584-5.036-3.711H.957v2.332A8.997 8.997 0 009 18z"></path><path fill="#FBBC05" d="M3.964 10.71A5.41 5.41 0 013.682 9c0-.593.102-1.17.282-1.71V4.958H.957A8.996 8.996 0 000 9c0 1.452.348 2.827.957 4.042l3.007-2.332z"></path><path fill="#EA4335" d="M9 3.58c1.321 0 2.508.454 3.44 1.345l2.582-2.58C13.463.891 11.426 0 9 0A8.997 8.997 0 00.957 4.958L3.964 7.29C4.672 5.163 6.656 3.58 9 3.58z"></path></svg>
          Google
        </button>
        <button class="btn-social" aria-label="Continue with Apple">
          <!-- Apple icon -->
          <svg width="18" height="18" viewBox="0 0 18 18" fill="currentColor"><path d="M12.625 0c.07.859-.247 1.711-.738 2.352-.499.65-1.32 1.156-2.111 1.09-.09-.843.302-1.72.778-2.314C11.04.462 11.918-.03 12.625 0zM15.5 12.367c-.317.728-.465 1.053-.868 1.698-.564.862-1.358 1.935-2.343 1.944-.875.009-1.1-.566-2.286-.558-1.188.007-1.436.568-2.314.56-1-.009-1.748-1-2.312-1.86-1.584-2.42-1.75-5.264-.773-6.772.694-1.08 1.786-1.713 2.815-1.713 1.047 0 1.706.568 2.573.568.84 0 1.353-.572 2.566-.572 1.014 0 2.012.553 2.703 1.505-.237.136-2.394 1.397-2.367 3.96.026 2.49 2.18 3.324 2.606 3.24z"></path></svg>
          Apple
        </button>
      </div>

      <div class="divider">
        <div class="divider-line"></div>
        <span class="divider-text">or continue with email</span>
        <div class="divider-line"></div>
      </div>

      <!-- Email -->
      <div class="form-group">
        <label class="form-label" for="loginEmail">Email address</label>
        <div class="input-wrapper">
          <span class="input-icon">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"></rect><path d="M22 6l-10 7L2 6"></path></svg>
          </span>
          <input type="email" id="loginEmail" class="form-input" placeholder="you@example.com" autocomplete="email">
          <div class="input-focus-line"></div>
        </div>
        <div class="input-feedback" id="loginEmailFeedback"></div>
      </div>

      <!-- Password -->
      <div class="form-group">
        <label class="form-label" for="loginPassword">Password</label>
        <div class="input-wrapper">
          <span class="input-icon">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"></rect><path d="M7 11V7a5 5 0 0110 0v4"></path></svg>
          </span>
          <input type="password" id="loginPassword" class="form-input" placeholder="Enter your password" autocomplete="current-password">
          <button class="toggle-pass" type="button" onclick="togglePass(&#39;loginPassword&#39;, this)" aria-label="Toggle password visibility">
            <svg class="eye-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
          </button>
          <div class="input-focus-line"></div>
        </div>
      </div>

      <div class="form-row-inline">
        <a href="file:///C:/Users/M4TRIX/Downloads/auth-system.html#" class="link-subtle">Forgot password?</a>
      </div>

      <button class="btn-primary" id="loginBtn" onclick="handleLogin()">
        <span class="btn-text">Sign In</span>
        <div class="btn-spinner" id="loginSpinner"></div>
      </button>

      <div class="toggle-panel">
        Don't have an account?&nbsp;
        <button onclick="switchPanel(&#39;register&#39;)">Create account</button>
      </div>
    </div>

    <!-- ===================== REGISTER PANEL ===================== -->
    <div class="panel active" id="panelRegister">

      <!-- Full Name -->
      <div class="form-group">
        <label class="form-label" for="regName">Full name</label>
        <div class="input-wrapper">
          <span class="input-icon">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
          </span>
          <input type="text" id="regName" class="form-input" placeholder="Alex Mercer" autocomplete="name" oninput="validateName(this)">
          <div class="input-focus-line"></div>
        </div>
        <div class="input-feedback" id="regNameFeedback"></div>
      </div>

      <!-- Email -->
      <div class="form-group">
        <label class="form-label" for="regEmail">Email address</label>
        <div class="input-wrapper">
          <span class="input-icon">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"></rect><path d="M22 6l-10 7L2 6"></path></svg>
          </span>
          <input type="email" id="regEmail" class="form-input" placeholder="you@example.com" autocomplete="email" oninput="validateEmail(this, &#39;regEmailFeedback&#39;)">
          <div class="input-focus-line"></div>
        </div>
        <div class="input-feedback" id="regEmailFeedback"></div>
      </div>

      <!-- Password -->
      <div class="form-group">
        <label class="form-label" for="regPassword">Password</label>
        <div class="input-wrapper">
          <span class="input-icon">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"></rect><path d="M7 11V7a5 5 0 0110 0v4"></path></svg>
          </span>
          <input type="password" id="regPassword" class="form-input" placeholder="Create a strong password" oninput="onPasswordInput()" autocomplete="new-password">
          <button class="toggle-pass" type="button" onclick="togglePass(&#39;regPassword&#39;, this)" aria-label="Toggle password visibility">
            <svg class="eye-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
          </button>
          <div class="input-focus-line"></div>
        </div>

        <!-- Strength bar -->
        <div class="strength-bar-container" id="strengthContainer">
          <div class="strength-label-row">
            <span class="strength-label">Password strength</span>
            <span class="strength-text" id="strengthText">—</span>
          </div>
          <div class="strength-track">
            <div class="strength-segment" id="seg1"></div>
            <div class="strength-segment" id="seg2"></div>
            <div class="strength-segment" id="seg3"></div>
            <div class="strength-segment" id="seg4"></div>
          </div>
        </div>
      </div>

      <!-- Confirm Password -->
      <div class="form-group">
        <label class="form-label" for="regConfirm">Confirm password</label>
        <div class="input-wrapper">
          <span class="input-icon">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
          </span>
          <input type="password" id="regConfirm" class="form-input" placeholder="Repeat your password" oninput="validateConfirm()" autocomplete="new-password">
          <button class="toggle-pass" type="button" onclick="togglePass(&#39;regConfirm&#39;, this)" aria-label="Toggle password visibility">
            <svg class="eye-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
          </button>
          <div class="input-focus-line"></div>
        </div>
        <div class="input-feedback" id="confirmFeedback"></div>
      </div>

      <button class="btn-primary" id="registerBtn" onclick="handleRegister()">
        <span class="btn-text">Create Account</span>
        <div class="btn-spinner" id="registerSpinner"></div>
      </button>

      <p class="terms-text">
        By creating an account, you agree to our
        <a href="file:///C:/Users/M4TRIX/Downloads/auth-system.html#">Terms of Service</a> and <a href="file:///C:/Users/M4TRIX/Downloads/auth-system.html#">Privacy Policy</a>.
      </p>

      <div class="toggle-panel">
        Already have an account?&nbsp;
        <button onclick="switchPanel(&#39;login&#39;)">Sign in</button>
      </div>
    </div>
    <!-- end register panel -->

  </div><!-- end auth-card -->
</div><!-- end page-wrapper -->

<script>
/* ============================================
   PARTICLE SYSTEM
   ============================================ */
(function spawnParticles() {
  const container = document.getElementById('particles');
  const COUNT = 30;
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

/* ============================================
   PANEL SWITCHING
   ============================================ */
function switchPanel(target) {
  const loginPanel  = document.getElementById('panelLogin');
  const regPanel    = document.getElementById('panelRegister');
  const heading     = document.getElementById('cardHeading');
  const subheading  = document.getElementById('cardSubheading');

  if (target === 'register') {
    loginPanel.classList.remove('active');
    regPanel.classList.add('active');
    heading.textContent    = 'Create account';
    subheading.textContent = 'Join the next generation of shopping';
  } else {
    regPanel.classList.remove('active');
    loginPanel.classList.add('active');
    heading.textContent    = 'Welcome back';
    subheading.textContent = 'Sign in to continue your experience';
  }

  // Scroll card to top
  document.getElementById('authCard').scrollTop = 0;
}

/* ============================================
   PASSWORD SHOW/HIDE
   ============================================ */
function togglePass(inputId, btn) {
  const input = document.getElementById(inputId);
  const isHidden = input.type === 'password';
  input.type = isHidden ? 'text' : 'password';

  const icon = btn.querySelector('.eye-icon');
  if (isHidden) {
    // Eye-off icon
    icon.innerHTML = `<path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/>`;
  } else {
    icon.innerHTML = `<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>`;
  }
}

/* ============================================
   VALIDATION HELPERS
   ============================================ */
function setFeedback(id, msg, type) {
  const el = document.getElementById(id);
  el.textContent = msg;
  el.className = `input-feedback${msg ? ' visible ' + type : ''}`;
}

function setInputState(input, state) {
  input.classList.remove('invalid', 'valid');
  if (state) input.classList.add(state);
}

function validateEmail(input, feedbackId) {
  const val = input.value.trim();
  if (!val) { setInputState(input, ''); setFeedback(feedbackId, '', ''); return false; }
  const ok = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val);
  setInputState(input, ok ? 'valid' : 'invalid');
  setFeedback(feedbackId, ok ? '✓ Looks good' : '✗ Invalid email address', ok ? 'success' : 'error');
  return ok;
}

function validateName(input) {
  const val = input.value.trim();
  if (!val) { setInputState(input, ''); setFeedback('regNameFeedback', '', ''); return false; }
  const ok = val.length >= 2 && /\s/.test(val);
  setInputState(input, ok ? 'valid' : 'invalid');
  setFeedback('regNameFeedback', ok ? '✓ Great name!' : '✗ Enter first and last name', ok ? 'success' : 'error');
  return ok;
}

/* ============================================
   PASSWORD STRENGTH
   ============================================ */
function getStrength(pass) {
  let score = 0;
  if (pass.length >= 8)  score++;
  if (pass.length >= 12) score++;
  if (/[A-Z]/.test(pass) && /[a-z]/.test(pass)) score++;
  if (/[0-9]/.test(pass)) score++;
  if (/[^A-Za-z0-9]/.test(pass)) score++;
  if (score <= 1) return { level: 1, label: 'Weak',   color: 'var(--error)'   };
  if (score <= 2) return { level: 2, label: 'Fair',   color: 'var(--warning)' };
  if (score <= 3) return { level: 3, label: 'Good',   color: 'var(--accent-blue)' };
  return            { level: 4, label: 'Strong', color: 'var(--success)'  };
}

function onPasswordInput() {
  const pass = document.getElementById('regPassword').value;
  const container = document.getElementById('strengthContainer');
  const segs = [document.getElementById('seg1'), document.getElementById('seg2'),
                document.getElementById('seg3'), document.getElementById('seg4')];
  const textEl = document.getElementById('strengthText');

  if (!pass) {
    container.classList.remove('show');
    segs.forEach(s => s.className = 'strength-segment');
    return;
  }

  container.classList.add('show');
  const { level, label, color } = getStrength(pass);
  textEl.textContent  = label;
  textEl.style.color  = color;

  const classMap = ['active-weak', 'active-fair', 'active-good', 'active-strong'];
  segs.forEach((seg, i) => {
    seg.className = 'strength-segment' + (i < level ? ' ' + classMap[level - 1] : '');
  });

  // Also update confirm if already filled
  validateConfirm();
}

function validateConfirm() {
  const pass    = document.getElementById('regPassword').value;
  const confirm = document.getElementById('regConfirm').value;
  const input   = document.getElementById('regConfirm');
  if (!confirm) { setInputState(input, ''); setFeedback('confirmFeedback', '', ''); return false; }
  const match = pass === confirm;
  setInputState(input, match ? 'valid' : 'invalid');
  setFeedback('confirmFeedback', match ? '✓ Passwords match' : '✗ Passwords do not match', match ? 'success' : 'error');
  return match;
}

/* ============================================
   BUTTON LOADING SIMULATION
   ============================================ */
function setLoading(btnId, spinnerId, loading) {
  const btn     = document.getElementById(btnId);
  const spinner = document.getElementById(spinnerId);
  const text    = btn.querySelector('.btn-text');
  if (loading) {
    btn.disabled = true;
    text.style.opacity = '0';
    spinner.style.display = 'block';
  } else {
    btn.disabled = false;
    text.style.opacity = '1';
    spinner.style.display = 'none';
  }
}

function handleLogin() {
  const email = document.getElementById('loginEmail').value;
  const password = document.getElementById('loginPassword').value;

  if (!email || !password) {
    alert("Enter email and password");
    return;
  }

  fetch("login.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded"
    },
    body: `email=${encodeURIComponent(email)}&password=${encodeURIComponent(password)}`
  })
  .then(res => res.text())
  .then(data => {
    console.log(data);

    if (data.trim() === "success") {
      window.location.href = "dashboard.php";
    } else {
      alert(data);
    }
  })
  .catch(err => {
    console.error(err);
  });
}

function handleRegister() {
  const name = document.getElementById('regName').value;
  const email = document.getElementById('regEmail').value;
  const password = document.getElementById('regPassword').value;

  // optional validation (keep your existing validation logic if you want)
  if (!name || !email || !password) {
    alert("Please fill all fields");
    return;
  }

  fetch("register.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded"
    },
    body: `name=${name}&email=${email}&password=${password}`
  })
  .then(response => response.text())
  .then(data => {
    if (data === "success") {
      alert("Account created successfully!");
      switchPanel('login'); // go to login page
    } else {
      alert("Error creating account");
    }
  })
  .catch(error => {
    console.error(error);
    alert("Something went wrong");
  });
}

</script>


</body></html>