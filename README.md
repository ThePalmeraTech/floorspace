# Perfect Stays – Technical Assessment

> **Start Timestamp:** First GitHub push → **22 Jul 2025 · 16:10 (GMT‑5 Panama)**
>
> This README outlines the tech stack, workflow, completed features, and pending items.

---

## 1 · Workflow Overview

1. **16:10 PM (GMT‑5)** — `git init` executed in `/wp-content/themes/perfect-stays`; first commit/push marked the official start.  
2. `composer create-project roots/sage perfect-stays` — headers & namespace updated.  
3. `yarn && yarn dev` to launch Vite + Tailwind.  
4. Scaffolded **Property** CPT and **Amenity** taxonomy using WP‑CLI (CPT UI used only for *Get Code*).  
5. Added the “Property Details” ACF PHP field group.  
6. Configured the Customizer → outputs global CSS variables.  
7. Built Blade templates (archive, single, about) and Gutenberg blocks; created sticky booking component.  
8. Quick QA on desktop & mobile.  
9. Final push and documentation.

---

## 2 · Local Setup

```bash
# Clone directly into the WordPress themes folder
cd wp-content/themes
git clone https://github.com/<user>/perfect-stays.git
cd perfect-stays
composer install
yarn && yarn dev          # use yarn build:production for a minified build
# Activate “Perfect Stays” theme from WP‑Admin › Appearance
```

---

## 3 · Status Overview

| Component                          | State | Notes |
|------------------------------------|-------|-------|
| Custom Post Type & Taxonomy        | ✅    | Code‑based (`property`, `amenity`) |
| Custom Fields (ACF)                | ✅    | Field group exported to PHP |
| Templates & About Page             | ✅    | Archive & single in Blade |
| Theme styles (Figma)               | ✅    | Responsive; minor pixel tweaks remain |
| Sticky Booking Box UI              | ✅    | Functional UI, no booking engine |
| **Gallery field**                  | 🔸    | Placeholder — requires ACF Pro |
| Booking logic / date picker        | 🔸    | Placeholder button/link |
| Maps autocomplete                  | 🔸    | Static Google Maps iframe |
| Fine‑grain design polish           | 🔸    | Small spacing/hover details pending |


---

## 4 · Key Decisions

* Adopted **Roots Sage 10** (Blade, Tailwind, Vite) to avoid manual build setup and match modern WP workflows.  
* Cloned a **personal Sage boilerplate** with Vite/Tailwind/ESLint pre‑wired to save setup time.  
* **CPT UI** served only as a *code generator*; it’s disabled in production — all registrations live in version‑controlled PHP.  
* ACF fields registered via `acf_add_local_field_group()` in `app/Custom/Fields/property-fields.php` to keep `functions.php` lean.  
* Left the gallery field as a placeholder because the free ACF version lacks gallery support.

---

## 5 · Next Steps

1. Upgrade to **ACF Pro** or implement a custom repeater to enable the property gallery.  
2. Integrate a booking engine (e.g., WooCommerce Bookings or external API) with the sticky booking box.  
3. Swap the static map for an interactive Google Maps component and add address autocomplete.  
4. Achieve pixel‑perfect polish: hover animations, micro‑spacing, font‑weights per Figma tokens.  
5. Add automated tests and CI for linting and deployment.

---

> **End Timestamp:** Before GitHub push → **22 Jul 2025 · 20:10 (GMT‑5 Panama)**

**Thank you for reviewing!**
