/**
 * SpinnerWheel.js
 * A canvas-based prize wheel with smooth easing, confetti burst, and winner overlay.
 *
 * Usage:
 *   const spinner = new SpinnerWheel({ el: '#spinner', items: [...] });
 *   spinner.onPicked = (item) => console.log(item);
 */
(function (global) {
  "use strict";

  /* ─── Palette ─────────────────────────────────────────────── */
  const PALETTES = [
    ["#FF6B6B", "#FF8E53"],
    ["#4ECDC4", "#44A08D"],
    ["#A18CD1", "#FBC2EB"],
    ["#F7971E", "#FFD200"],
    ["#56CCF2", "#2F80ED"],
    ["#F953C6", "#B91D73"],
    ["#11998E", "#38EF7D"],
    ["#FC5C7D", "#6A3093"],
    ["#FDDB92", "#D1FDFF"],
    ["#4776E6", "#8E54E9"],
  ];

  /* ─── Easing ───────────────────────────────────────────────── */
  function easeOutQuint(t) {
    return 1 - Math.pow(1 - t, 5);
  }

  /* ─── Confetti ─────────────────────────────────────────────── */
  function launchConfetti(cx, cy, canvas) {
    const ctx = canvas.getContext("2d");
    const particles = [];
    const colors = ["#FF6B6B","#FFD200","#4ECDC4","#A18CD1","#56CCF2","#F953C6","#38EF7D"];
    for (let i = 0; i < 120; i++) {
      const angle = Math.random() * Math.PI * 2;
      const speed = 3 + Math.random() * 6;
      particles.push({
        x: cx, y: cy,
        vx: Math.cos(angle) * speed,
        vy: Math.sin(angle) * speed - 4,
        color: colors[Math.floor(Math.random() * colors.length)],
        size: 4 + Math.random() * 6,
        life: 1,
        decay: 0.018 + Math.random() * 0.012,
        rotation: Math.random() * Math.PI * 2,
        rotSpeed: (Math.random() - 0.5) * 0.3,
        shape: Math.random() > 0.5 ? "rect" : "circle",
      });
    }

    let lastTs = null;
    function animConfetti(ts) {
      if (!lastTs) lastTs = ts;
      const dt = Math.min((ts - lastTs) / 16.67, 3);
      lastTs = ts;

      ctx.save();
      for (const p of particles) {
        p.x += p.vx * dt;
        p.vy += 0.18 * dt;
        p.y += p.vy * dt;
        p.vx *= 0.99;
        p.life -= p.decay * dt;
        p.rotation += p.rotSpeed * dt;

        if (p.life <= 0) continue;
        ctx.save();
        ctx.globalAlpha = Math.max(0, p.life);
        ctx.translate(p.x, p.y);
        ctx.rotate(p.rotation);
        ctx.fillStyle = p.color;
        if (p.shape === "rect") {
          ctx.fillRect(-p.size / 2, -p.size / 4, p.size, p.size / 2);
        } else {
          ctx.beginPath();
          ctx.arc(0, 0, p.size / 2, 0, Math.PI * 2);
          ctx.fill();
        }
        ctx.restore();
      }
      ctx.restore();

      if (particles.some(p => p.life > 0)) {
        requestAnimationFrame(animConfetti);
      }
    }
    requestAnimationFrame(animConfetti);
  }

  /* ─── SpinnerWheel Class ───────────────────────────────────── */
  class SpinnerWheel {
    constructor(options = {}) {
      this.el = typeof options.el === "string"
        ? document.querySelector(options.el)
        : options.el;

      if (!this.el) throw new Error("SpinnerWheel: element not found");

      this.items = options.items || [];
      this.onPicked = options.onPicked || null;
      this.onSpin = options.onSpin || null;
      this.onClose = options.onClose || null;

      this._angle = 0;           // current rotation in radians
      this._spinning = false;
      this._winner = null;

      this._build();
      this._draw();
    }

    /* ── DOM scaffold ──────────────────────────────────────────── */
    _build() {
      const size = Math.min(
        this.el.clientWidth || 480,
        window.innerWidth > 600 ? 480 : window.innerWidth - 32
      );

      this.el.style.position = "relative";
      this.el.style.width  = size + "px";
      this.el.style.height = size + "px";
      this.el.style.margin = "0 auto";
      this.el.style.fontFamily = "'Segoe UI', system-ui, sans-serif";

      /* Outer glow ring */
      const ring = document.createElement("div");
      Object.assign(ring.style, {
        position: "absolute", inset: "0",
        borderRadius: "50%",
        background: "conic-gradient(from 0deg, #FF6B6B, #FFD200, #4ECDC4, #A18CD1, #FF6B6B)",
        padding: "6px",
        boxSizing: "border-box",
        boxShadow: "0 0 40px rgba(255,107,107,.45), 0 0 80px rgba(160,128,209,.25)",
      });

      /* Canvas wrapper (clipped circle) */
      const wrap = document.createElement("div");
      Object.assign(wrap.style, {
        position: "absolute", inset: "6px",
        borderRadius: "50%",
        overflow: "hidden",
        background: "#0d0d0d",
      });

      this._canvas = document.createElement("canvas");
      this._canvas.width  = size - 12;
      this._canvas.height = size - 12;
      Object.assign(this._canvas.style, {
        display: "block", cursor: "pointer",
        borderRadius: "50%",
      });
      wrap.appendChild(this._canvas);
      ring.appendChild(wrap);
      this.el.appendChild(ring);

      /* Pointer arrow */
      const ptr = document.createElement("div");
      Object.assign(ptr.style, {
        position: "absolute",
        top: "-12px",
        left: "50%",
        transform: "translateX(-50%)",
        width: "0", height: "0",
        borderLeft:   "18px solid transparent",
        borderRight:  "18px solid transparent",
        borderTop:    "36px solid #FFD200",
        filter: "drop-shadow(0 2px 6px rgba(0,0,0,.5))",
        zIndex: "10",
      });
      this.el.appendChild(ptr);

      /* Spin button (centre hub) */
      this._hub = document.createElement("button");
      const hubSize = Math.round(size * 0.18);
      Object.assign(this._hub.style, {
        position: "absolute",
        top: "50%", left: "50%",
        transform: "translate(-50%,-50%)",
        width: hubSize + "px", height: hubSize + "px",
        borderRadius: "50%",
        border: "4px solid rgba(255,255,255,.15)",
        background: "radial-gradient(circle at 35% 35%, #ffffff22, #0d0d0d)",
        color: "#fff",
        fontSize: Math.round(hubSize * 0.2) + "px",
        fontWeight: "700",
        letterSpacing: "0.04em",
        cursor: "pointer",
        zIndex: "10",
        textTransform: "uppercase",
        boxShadow: "0 4px 20px rgba(0,0,0,.6), inset 0 1px 0 rgba(255,255,255,.1)",
        transition: "transform .15s, box-shadow .15s",
      });
      this._hub.textContent = "SPIN";
      this._hub.addEventListener("mouseenter", () => {
        if (!this._spinning) this._hub.style.transform = "translate(-50%,-50%) scale(1.08)";
      });
      this._hub.addEventListener("mouseleave", () => {
        this._hub.style.transform = "translate(-50%,-50%) scale(1)";
      });
      this._hub.addEventListener("click", () => this.spin());
      this.el.appendChild(this._hub);

      /* Winner overlay */
      this._overlay = document.createElement("div");
      Object.assign(this._overlay.style, {
        position: "absolute", inset: "0",
        borderRadius: "50%",
        display: "flex", flexDirection: "column",
        alignItems: "center", justifyContent: "center",
        background: "rgba(13,13,13,.88)",
        backdropFilter: "blur(6px)",
        zIndex: "20",
        opacity: "0",
        pointerEvents: "none",
        transition: "opacity .4s",
      });

      const overlayLabel = document.createElement("div");
      Object.assign(overlayLabel.style, {
        color: "#FFD200",
        fontSize: Math.round(size * 0.055) + "px",
        fontWeight: "800",
        letterSpacing: ".12em",
        textTransform: "uppercase",
        marginBottom: "8px",
        opacity: ".7",
      });
      overlayLabel.textContent = "🏆 Winner";

      this._overlayName = document.createElement("div");
      Object.assign(this._overlayName.style, {
        color: "#fff",
        fontSize: Math.round(size * 0.1) + "px",
        fontWeight: "900",
        letterSpacing: "-.01em",
        textAlign: "center",
        padding: "0 20px",
        lineHeight: "1.1",
        textShadow: "0 0 30px rgba(255,210,0,.5)",
      });

      const closeBtn = document.createElement("button");
      Object.assign(closeBtn.style, {
        marginTop: "20px",
        padding: "10px 28px",
        borderRadius: "999px",
        border: "none",
        background: "linear-gradient(135deg, #FF6B6B, #FFD200)",
        color: "#0d0d0d",
        fontSize: Math.round(size * 0.038) + "px",
        fontWeight: "800",
        cursor: "pointer",
        letterSpacing: ".06em",
        textTransform: "uppercase",
        boxShadow: "0 4px 20px rgba(255,210,0,.3)",
      });
      closeBtn.textContent = "Spin Again";
      closeBtn.addEventListener("click", () => {
        this._overlay.style.opacity = "0";
        this._overlay.style.pointerEvents = "none";
        this._hub.textContent = "SPIN";
        if (this.onClose) {
          this.onClose();
        }
      });

      this._overlay.appendChild(overlayLabel);
      this._overlay.appendChild(this._overlayName);
      this._overlay.appendChild(closeBtn);
      this.el.appendChild(this._overlay);

      this._size = size;
      this._ctx  = this._canvas.getContext("2d");
    }

    /* ── Drawing ───────────────────────────────────────────────── */
    _draw() {
      const ctx  = this._ctx;
      const n    = this.items.length;
      const cx   = this._canvas.width  / 2;
      const cy   = this._canvas.height / 2;
      const r    = Math.min(cx, cy) - 4;
      const arc  = (Math.PI * 2) / n;

      ctx.clearRect(0, 0, this._canvas.width, this._canvas.height);

      if (n === 0) {
        ctx.fillStyle = "#333";
        ctx.beginPath();
        ctx.arc(cx, cy, r, 0, Math.PI * 2);
        ctx.fill();
        return;
      }

      for (let i = 0; i < n; i++) {
        const start = this._angle + arc * i - Math.PI / 2;
        const end   = start + arc;
        const [c1, c2] = PALETTES[i % PALETTES.length];

        /* Segment gradient */
        const midAngle = start + arc / 2;
        const gx1 = cx + (r * 0.3) * Math.cos(midAngle);
        const gy1 = cy + (r * 0.3) * Math.sin(midAngle);
        const gx2 = cx + r * Math.cos(midAngle);
        const gy2 = cy + r * Math.sin(midAngle);
        const grad = ctx.createLinearGradient(gx1, gy1, gx2, gy2);
        grad.addColorStop(0, c1);
        grad.addColorStop(1, c2);

        ctx.beginPath();
        ctx.moveTo(cx, cy);
        ctx.arc(cx, cy, r, start, end);
        ctx.closePath();
        ctx.fillStyle = grad;
        ctx.fill();

        /* Divider line */
        ctx.beginPath();
        ctx.moveTo(cx, cy);
        ctx.lineTo(cx + r * Math.cos(start), cy + r * Math.sin(start));
        ctx.strokeStyle = "rgba(0,0,0,.35)";
        ctx.lineWidth = 2;
        ctx.stroke();

        /* Label */
        ctx.save();
        ctx.translate(cx, cy);
        ctx.rotate(midAngle);
        ctx.textAlign = "right";
        ctx.textBaseline = "middle";

        const fontSize = Math.max(11, Math.min(22, (r * 0.36) / Math.max(1, this.items[i].name.length * 0.55)));
        ctx.font = `700 ${fontSize}px 'Segoe UI', system-ui, sans-serif`;

        /* Text shadow */
        ctx.shadowColor = "rgba(0,0,0,.5)";
        ctx.shadowBlur  = 4;
        ctx.fillStyle   = "rgba(255,255,255,.95)";
        ctx.fillText(this.items[i].name, r - 14, 0);
        ctx.restore();
      }

      /* Outer rim */
      ctx.beginPath();
      ctx.arc(cx, cy, r, 0, Math.PI * 2);
      ctx.strokeStyle = "rgba(255,255,255,.08)";
      ctx.lineWidth   = 3;
      ctx.stroke();

      /* Centre cap */
      const capR = this._size * 0.075;
      const capGrad = ctx.createRadialGradient(cx - capR * .3, cy - capR * .3, 1, cx, cy, capR);
      capGrad.addColorStop(0, "#444");
      capGrad.addColorStop(1, "#111");
      ctx.beginPath();
      ctx.arc(cx, cy, capR, 0, Math.PI * 2);
      ctx.fillStyle = capGrad;
      ctx.fill();
      ctx.strokeStyle = "rgba(255,255,255,.12)";
      ctx.lineWidth = 2;
      ctx.stroke();
    }

    /* ── Spin ──────────────────────────────────────────────────── */
    spin() {
        if (this.onSpin) {
          this.onSpin();
        }
      if (this._spinning || this.items.length === 0) return;
      this._spinning = true;
      this._winner = null;
      this._hub.textContent = "…";

      /* Close any open overlay */
      this._overlay.style.opacity = "0";
      this._overlay.style.pointerEvents = "none";

      const n          = this.items.length;
      const arc        = (Math.PI * 2) / n;
      const extraSpins = (5 + Math.floor(Math.random() * 5)) * Math.PI * 2;
      const targetIdx  = Math.floor(Math.random() * n);

      /* Align pointer (pointing right → +x axis → angle 0 from centre)
         Segment i occupies [i*arc, (i+1)*arc] relative to rotation.
         We want the midpoint of segment targetIdx to land at angle 0. */
      const targetMid = arc * targetIdx + arc / 2;
      /* How far does the wheel need to turn so targetMid hits 0 (mod 2π)? */
      const needed    = ((-this._angle - targetMid) % (Math.PI * 2) + Math.PI * 2) % (Math.PI * 2);
      const totalRot  = extraSpins + needed;

      const startAngle = this._angle;
      const duration   = 4000 + Math.random() * 1500;
      let   startTime  = null;

      const tick = (ts) => {
        if (!startTime) startTime = ts;
        const elapsed = ts - startTime;
        const progress = Math.min(elapsed / duration, 1);
        const eased    = easeOutQuint(progress);

        this._angle = startAngle + totalRot * eased;
        this._draw();

        if (progress < 1) {
          requestAnimationFrame(tick);
        } else {
          this._angle = startAngle + totalRot;
          this._spinning = false;
          this._winner = this.items[targetIdx];
          this._showWinner();
          if (typeof this.onPicked === "function") this.onPicked(this._winner);
        }
      };

      requestAnimationFrame(tick);
    }

    /* ── Winner overlay ────────────────────────────────────────── */
    _showWinner() {
      this._overlayName.textContent = this._winner.name;
      this._overlay.style.opacity = "1";
      this._overlay.style.pointerEvents = "auto";
      this._hub.textContent = "SPIN";

      const cx = this._canvas.width  / 2 + this._canvas.offsetLeft;
      const cy = this._canvas.height / 2 + this._canvas.offsetTop;
      launchConfetti(cx + (this._canvas.getBoundingClientRect().left - this.el.getBoundingClientRect().left),
                     cy + (this._canvas.getBoundingClientRect().top  - this.el.getBoundingClientRect().top),
                     this._canvas);
    }

    /* ── Public helpers ────────────────────────────────────────── */
    setItems(items) {
      this.items = items;
      this._angle = 0;
      this._draw();
    }

    addItem(item) {
      this.items.push(item);
      this._draw();
    }

    removeItem(id) {
      this.items = this.items.filter(i => i.id !== id);
      this._draw();
    }
  }

  /* ── Export ────────────────────────────────────────────────── */
  if (typeof module !== "undefined" && module.exports) {
    module.exports = SpinnerWheel;
  } else {
    global.SpinnerWheel = SpinnerWheel;
  }

})(typeof window !== "undefined" ? window : this);