window.hs_config = {
  previewMode: false,
  vars: { themeFont: "https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap", version: "?v=1.0" },
  layoutBuilder: {
    extend: { switcherSupport: true },
    header: { layoutMode: "default", containerMode: "container-fluid" },
    sidebarLayout: "default",
  },
  themeAppearance: {
    layoutSkin: "default",
    sidebarSkin: "default",
    styles: {
      colors: { primary: "#377dff", transparent: "transparent", white: "#fff", dark: "132144", gray: { 100: "#f9fafc", 900: "#1e2022" } },
      font: "Inter",
    },
  },
  languageDirection: { lang: "en" },
};
window.hs_config.gulpRGBA = (p1) => {
  const options = p1.split(",");
  const hex = options[0].toString();
  const transparent = options[1].toString();

  let c;
  if (/^#([A-Fa-f0-9]{3}){1,2}$/.test(hex)) {
    c = hex.substring(1).split("");
    if (c.length === 3) {
      c = [c[0], c[0], c[1], c[1], c[2], c[2]];
    }
    c = "0x" + c.join("");
    return "rgba(" + [(c >> 16) & 255, (c >> 8) & 255, c & 255].join(",") + "," + transparent + ")";
  }
  throw new Error("Bad Hex");
};
