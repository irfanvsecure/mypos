// Cinematic 3D backdrop for dark heroes: coins, FBR receipts, payment cards and product boxes drifting in a lit,
// fogged space, with mouse parallax and a scroll-driven camera push. Loaded lazily by app.js into [data-hero3d].
import * as THREE from '../vendor/three.module.min.js';

export function mount(host) {
  const small = window.matchMedia('(max-width: 760px)').matches;
  const renderer = new THREE.WebGLRenderer({ antialias: !small, alpha: true, powerPreference: 'low-power' });
  renderer.setPixelRatio(Math.min(window.devicePixelRatio, small ? 1.25 : 1.75));
  renderer.outputColorSpace = THREE.SRGBColorSpace;
  renderer.toneMapping = THREE.ACESFilmicToneMapping;
  host.appendChild(renderer.domElement);

  const scene = new THREE.Scene();
  scene.fog = new THREE.Fog(0x071a2e, 9, 26);
  const camera = new THREE.PerspectiveCamera(42, 1, 0.1, 60);
  camera.position.set(0, 0, 12);

  scene.add(new THREE.HemisphereLight(0x9fdcff, 0x0a1b33, 1.1));
  const key = new THREE.DirectionalLight(0xffffff, 1.6); key.position.set(5, 6, 8); scene.add(key);
  const rim = new THREE.PointLight(0xff7a45, 40, 30); rim.position.set(-7, -3, 4); scene.add(rim);
  const glow = new THREE.PointLight(0x5cc8ff, 55, 30); glow.position.set(6, 2, 2); scene.add(glow);

  // Canvas-drawn textures keep the scene self-contained (no image requests).
  const tex = (w, h, draw) => {
    const c = document.createElement('canvas'); c.width = w; c.height = h;
    draw(c.getContext('2d'), w, h);
    const t = new THREE.CanvasTexture(c); t.colorSpace = THREE.SRGBColorSpace; t.anisotropy = 4;
    return t;
  };
  const receiptTex = tex(256, 512, (g, w, h) => {
    g.fillStyle = '#ffffff'; g.fillRect(0, 0, w, h);
    g.fillStyle = '#0a2540'; g.font = 'bold 26px Arial'; g.textAlign = 'center'; g.fillText('myPOS', w / 2, 46);
    g.fillStyle = '#9aa7b8';
    for (let y = 80; y < 300; y += 26) { g.fillRect(22, y, 120 + ((y * 7) % 60), 9); g.fillRect(w - 70, y, 48, 9); }
    g.fillStyle = '#0a2540'; g.fillRect(22, 316, w - 44, 3); g.font = 'bold 22px Arial'; g.textAlign = 'left'; g.fillText('TOTAL', 22, 350);
    g.textAlign = 'right'; g.fillText('Rs 3,087', w - 22, 350);
    for (let y = 0; y < 13; y++) for (let x = 0; x < 13; x++) {
      const finder = (x < 4 && y < 4) || (x > 8 && y < 4) || (x < 4 && y > 8);
      if (finder ? (x % 3 === 0 || y % 3 === 0 || (x % 3 === 1 && y % 3 === 1)) : ((x * 31 + y * 17) % 7) < 3) g.fillRect(70 + x * 9, 372 + y * 9, 9, 9);
    }
    g.fillStyle = '#1fa855'; g.font = 'bold 15px Arial'; g.textAlign = 'center'; g.fillText('FBR VERIFIED', w / 2, 500);
  });
  const cardTex = tex(512, 320, (g, w, h) => {
    const gr = g.createLinearGradient(0, 0, w, h); gr.addColorStop(0, '#1a5a8e'); gr.addColorStop(1, '#071a2e');
    g.fillStyle = gr; g.fillRect(0, 0, w, h);
    g.fillStyle = '#e8c36a'; g.fillRect(48, 110, 70, 52);
    g.fillStyle = 'rgba(255,255,255,.85)'; g.font = '28px Arial'; g.fillText('••••  ••••  ••••  2026', 48, 230);
    g.font = 'bold 30px Arial'; g.fillStyle = '#ff9a6e'; g.fillText('myPOS', 48, 70);
  });

  const coinMat = new THREE.MeshStandardMaterial({ color: 0xf2b84b, metalness: 0.55, roughness: 0.32, emissive: 0x6b4206, emissiveIntensity: 0.35 });
  const coinGeo = new THREE.CylinderGeometry(0.42, 0.42, 0.08, small ? 24 : 40);
  const receiptGeo = new THREE.PlaneGeometry(0.9, 1.8);
  const receiptMat = new THREE.MeshStandardMaterial({ map: receiptTex, roughness: 0.6, side: THREE.DoubleSide });
  const cardGeo = new THREE.BoxGeometry(1.6, 1.0, 0.04);
  const cardMat = new THREE.MeshStandardMaterial({ map: cardTex, metalness: 0.3, roughness: 0.4 });
  const boxGeo = new THREE.BoxGeometry(0.6, 0.6, 0.6);
  const boxMats = [0xc8461c, 0x5cc8ff, 0x1a5a8e].map(c => new THREE.MeshStandardMaterial({ color: c, roughness: 0.35, metalness: 0.15 }));

  const floaters = [];
  const kinds = small ? 14 : 26;
  for (let i = 0; i < kinds; i++) {
    const k = i % 4;
    const m = k === 0 ? new THREE.Mesh(coinGeo, coinMat)
      : k === 1 ? new THREE.Mesh(receiptGeo, receiptMat)
      : k === 2 ? new THREE.Mesh(cardGeo, cardMat)
      : new THREE.Mesh(boxGeo, boxMats[i % 3]);
    // Keep the middle-left (headline + form) clear: objects favour the right side and the far background.
    // Left-side objects sit far out and deep in the fog so they never cross the text column.
    if (Math.random() < 0.75) m.position.set(1.5 + Math.random() * 7, (Math.random() - 0.5) * 8, -Math.random() * 9 + 1);
    else m.position.set(-(9 + Math.random() * 5), (Math.random() - 0.5) * 9, -7 - Math.random() * 6);
    m.rotation.set(Math.random() * 6, Math.random() * 6, Math.random() * 6);
    m.userData = { spin: (Math.random() - 0.5) * 0.6, bob: Math.random() * 6, speed: 0.25 + Math.random() * 0.35, y: m.position.y };
    if (k === 0) m.rotation.x = Math.PI / 2 + (Math.random() - 0.5);
    scene.add(m); floaters.push(m);
  }

  // Glowing dust for depth.
  const n = small ? 500 : 1400, pos = new Float32Array(n * 3);
  for (let i = 0; i < n; i++) { pos[i * 3] = (Math.random() - 0.5) * 30; pos[i * 3 + 1] = (Math.random() - 0.5) * 18; pos[i * 3 + 2] = -Math.random() * 22 + 4; }
  const dustGeo = new THREE.BufferGeometry(); dustGeo.setAttribute('position', new THREE.BufferAttribute(pos, 3));
  const dot = tex(64, 64, (g) => { const r = g.createRadialGradient(32, 32, 0, 32, 32, 32); r.addColorStop(0, 'rgba(255,255,255,1)'); r.addColorStop(.3, 'rgba(160,220,255,.6)'); r.addColorStop(1, 'rgba(160,220,255,0)'); g.fillStyle = r; g.fillRect(0, 0, 64, 64); });
  const dust = new THREE.Points(dustGeo, new THREE.PointsMaterial({ size: 0.12, map: dot, transparent: true, depthWrite: false, blending: THREE.AdditiveBlending, color: 0x9fdcff }));
  scene.add(dust);

  // Perspective floor grid that fades into the fog.
  const grid = new THREE.GridHelper(60, 60, 0x5cc8ff, 0x1a5a8e);
  grid.position.y = -4.2; grid.material.transparent = true; grid.material.opacity = 0.22; scene.add(grid);

  const mouse = { x: 0, y: 0, tx: 0, ty: 0 };
  const onMove = (e) => { mouse.tx = (e.clientX / window.innerWidth - 0.5) * 2; mouse.ty = (e.clientY / window.innerHeight - 0.5) * 2; };
  window.addEventListener('pointermove', onMove, { passive: true });

  const resize = () => {
    const w = host.clientWidth, h = host.clientHeight || 1;
    renderer.setSize(w, h, false); camera.aspect = w / h; camera.updateProjectionMatrix();
  };
  resize(); window.addEventListener('resize', resize);

  let onScreen = true, visible = true, raf = 0;
  const clock = new THREE.Clock();
  const frame = () => {
    raf = 0; if (!visible) return;
    const t = clock.getElapsedTime();
    const rect = host.getBoundingClientRect();
    const scroll = Math.min(1, Math.max(0, -rect.top / (rect.height || 1)));   // 0 at top of hero → 1 when scrolled past
    mouse.x += (mouse.tx - mouse.x) * 0.05; mouse.y += (mouse.ty - mouse.y) * 0.05;
    camera.position.x = mouse.x * 0.9;
    camera.position.y = -mouse.y * 0.6 - scroll * 1.5;
    camera.position.z = 12 - scroll * 5;
    camera.lookAt(0, -scroll * 1.2, 0);
    floaters.forEach((m) => {
      const u = m.userData;
      m.rotation.y += u.spin * 0.01; m.rotation.z += u.spin * 0.004;
      m.position.y = u.y + Math.sin(t * u.speed + u.bob) * 0.35;
    });
    dust.rotation.y = t * 0.012;
    grid.position.z = (t * 0.6) % 1;
    renderer.render(scene, camera);
    raf = requestAnimationFrame(frame);
  };
  const wake = () => { visible = onScreen && !document.hidden; if (visible && !raf) raf = requestAnimationFrame(frame); };
  new IntersectionObserver(([e]) => { onScreen = e.isIntersecting; wake(); }).observe(host);
  document.addEventListener('visibilitychange', wake);
  host.classList.add('is-live');
  raf = requestAnimationFrame(frame);
}
