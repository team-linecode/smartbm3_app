!(function () {
    var g,
        c,
        d,
        a,
        h,
        k,
        r,
        l,
        b,
        s,
        t = document.querySelector(".navbar-menu").innerHTML,
        e = localStorage.getItem("language");
    function m(a) {
        var b;
        document.getElementById("header-lang-img") &&
            ("en" == a
                ? (document.getElementById("header-lang-img").src =
                      "assets/images/flags/us.svg")
                : "sp" == a
                ? (document.getElementById("header-lang-img").src =
                      "assets/images/flags/spain.svg")
                : "gr" == a
                ? (document.getElementById("header-lang-img").src =
                      "assets/images/flags/germany.svg")
                : "it" == a
                ? (document.getElementById("header-lang-img").src =
                      "assets/images/flags/italy.svg")
                : "ru" == a
                ? (document.getElementById("header-lang-img").src =
                      "assets/images/flags/russia.svg")
                : "ch" == a
                ? (document.getElementById("header-lang-img").src =
                      "assets/images/flags/china.svg")
                : "fr" == a &&
                  (document.getElementById("header-lang-img").src =
                      "assets/images/flags/french.svg"),
            localStorage.setItem("language", a),
            null == (e = localStorage.getItem("language")) && m("en"),
            (b = new XMLHttpRequest()).open(
                "GET",
                "assets/lang/" + e + ".json"
            ),
            (b.onreadystatechange = function () {
                var a;
                4 === this.readyState &&
                    200 === this.status &&
                    ((a = JSON.parse(this.responseText)),
                    Object.keys(a).forEach(function (b) {
                        document
                            .querySelectorAll("[data-key='" + b + "']")
                            .forEach(function (c) {
                                c.textContent = a[b];
                            });
                    }));
            }),
            b.send());
    }
    function n() {
        document.querySelectorAll(".navbar-nav .collapse") &&
            document
                .querySelectorAll(".navbar-nav .collapse")
                .forEach(function (a) {
                    var b = new bootstrap.Collapse(a, { toggle: !1 });
                    a.addEventListener("show.bs.collapse", function (c) {
                        c.stopPropagation(),
                            (c = a.parentElement.closest(".collapse"))
                                ? c
                                      .querySelectorAll(".collapse")
                                      .forEach(function (a) {
                                          (a =
                                              bootstrap.Collapse.getInstance(
                                                  a
                                              )) !== b && a.hide();
                                      })
                                : (function (b) {
                                      for (
                                          var c = [],
                                              a = b.parentNode.firstChild;
                                          a;

                                      )
                                          1 === a.nodeType &&
                                              a !== b &&
                                              c.push(a),
                                              (a = a.nextSibling);
                                      return c;
                                  })(a.parentElement).forEach(function (a) {
                                      2 < a.childNodes.length &&
                                          a.firstElementChild.setAttribute(
                                              "aria-expanded",
                                              "false"
                                          ),
                                          a
                                              .querySelectorAll("*[id]")
                                              .forEach(function (a) {
                                                  a.classList.remove("show"),
                                                      2 < a.childNodes.length &&
                                                          a
                                                              .querySelectorAll(
                                                                  "ul li a"
                                                              )
                                                              .forEach(
                                                                  function (a) {
                                                                      a.hasAttribute(
                                                                          "aria-expanded"
                                                                      ) &&
                                                                          a.setAttribute(
                                                                              "aria-expanded",
                                                                              "false"
                                                                          );
                                                                  }
                                                              );
                                              });
                                  });
                    }),
                        a.addEventListener("hide.bs.collapse", function (b) {
                            b.stopPropagation(),
                                a
                                    .querySelectorAll(".collapse")
                                    .forEach(function (a) {
                                        (childCollapseInstance =
                                            bootstrap.Collapse.getInstance(
                                                a
                                            )).hide();
                                    });
                        });
                });
    }
    function o() {
        var c,
            a,
            d = document.documentElement.getAttribute("data-layout"),
            b = sessionStorage.getItem("defaultAttribute"),
            b = JSON.parse(b);
        b &&
            ("twocolumn" == d || "twocolumn" == b["data-layout"]) &&
            ((document.querySelector(".navbar-menu").innerHTML = t),
            ((c = document.createElement("ul")).innerHTML =
                '<a href="#" class="logo"><img src="assets/images/logo-sm.png" alt="" height="22"></a>'),
            document
                .getElementById("navbar-nav")
                .querySelectorAll(".menu-link")
                .forEach(function (b) {
                    c.className = "twocolumn-iconview";
                    var d = document.createElement("li"),
                        a = b;
                    a.querySelectorAll("span").forEach(function (a) {
                        a.classList.add("d-none");
                    }),
                        b.parentElement.classList.contains(
                            "twocolumn-item-show"
                        ) && b.classList.add("active"),
                        d.appendChild(a),
                        c.appendChild(d),
                        a.classList.contains("nav-link") &&
                            a.classList.replace("nav-link", "nav-icon"),
                        a.classList.remove("collapsed", "menu-link");
                }),
            (b = (b =
                "/" == location.pathname
                    ? "index.html"
                    : location.pathname.substring(1)).substring(
                b.lastIndexOf("/") + 1
            )) &&
                (!(b = document
                    .getElementById("navbar-nav")
                    .querySelector('[href="' + b + '"]')) ||
                    ((a = b.closest(".collapse.menu-dropdown")) &&
                        (a.classList.add("show"),
                        a.parentElement.children[0].classList.add("active"),
                        a.parentElement.children[0].setAttribute(
                            "aria-expanded",
                            "true"
                        ),
                        a.parentElement.closest(".collapse.menu-dropdown") &&
                            (a.parentElement
                                .closest(".collapse")
                                .classList.add("show"),
                            a.parentElement.closest(".collapse")
                                .previousElementSibling &&
                                a.parentElement
                                    .closest(".collapse")
                                    .previousElementSibling.classList.add(
                                        "active"
                                    ))))),
            (document.getElementById("two-column-menu").innerHTML =
                c.outerHTML),
            document
                .querySelector("#two-column-menu ul")
                .querySelectorAll("li a")
                .forEach(function (a) {
                    var b = (b =
                        "/" == location.pathname
                            ? "index.html"
                            : location.pathname.substring(1)).substring(
                        b.lastIndexOf("/") + 1
                    );
                    a.addEventListener("click", function (c) {
                        var d;
                        (b != "/" + a.getAttribute("href") ||
                            a.getAttribute("data-bs-toggle")) &&
                            document.body.classList.contains(
                                "twocolumn-panel"
                            ) &&
                            document.body.classList.remove("twocolumn-panel"),
                            document
                                .getElementById("navbar-nav")
                                .classList.remove("twocolumn-nav-hide"),
                            document
                                .querySelector(".hamburger-icon")
                                .classList.remove("open"),
                            ((c.target && c.target.matches("a.nav-icon")) ||
                                (c.target && c.target.matches("i"))) &&
                                (null !==
                                    document.querySelector(
                                        "#two-column-menu ul .nav-icon.active"
                                    ) &&
                                    document
                                        .querySelector(
                                            "#two-column-menu ul .nav-icon.active"
                                        )
                                        .classList.remove("active"),
                                (c.target.matches("i")
                                    ? c.target.closest("a")
                                    : c.target
                                ).classList.add("active"),
                                0 <
                                    (d = document.getElementsByClassName(
                                        "twocolumn-item-show"
                                    )).length &&
                                    d[0].classList.remove(
                                        "twocolumn-item-show"
                                    ),
                                (c = (
                                    c.target.matches("i")
                                        ? c.target.closest("a")
                                        : c.target
                                )
                                    .getAttribute("href")
                                    .slice(1)),
                                document.getElementById(c) &&
                                    document
                                        .getElementById(c)
                                        .parentElement.classList.add(
                                            "twocolumn-item-show"
                                        ));
                    }),
                        b != "/" + a.getAttribute("href") ||
                            a.getAttribute("data-bs-toggle") ||
                            (a.classList.add("active"),
                            document
                                .getElementById("navbar-nav")
                                .classList.add("twocolumn-nav-hide"),
                            document
                                .querySelector(".hamburger-icon")
                                .classList.add("open"));
                }),
            "horizontal" !==
                document.documentElement.getAttribute("data-layout") &&
                ((a = new SimpleBar(
                    document.getElementById("navbar-nav")
                )).getContentElement(),
                (a = new SimpleBar(
                    document.getElementsByClassName("twocolumn-iconview")[0]
                )).getContentElement()));
    }
    function p(a) {
        if (a) {
            var b = a.offsetTop,
                c = a.offsetLeft,
                d = a.offsetWidth,
                e = a.offsetHeight;
            if (a.offsetParent)
                for (; a.offsetParent; )
                    (b += (a = a.offsetParent).offsetTop), (c += a.offsetLeft);
            return (
                b >= window.pageYOffset &&
                c >= window.pageXOffset &&
                b + e <= window.pageYOffset + window.innerHeight &&
                c + d <= window.pageXOffset + window.innerWidth
            );
        }
    }
    function q() {
        "vertical" == document.documentElement.getAttribute("data-layout") &&
            ((document.getElementById("two-column-menu").innerHTML = ""),
            (document.querySelector(".navbar-menu").innerHTML = t),
            document
                .getElementById("scrollbar")
                .setAttribute("data-simplebar", ""),
            document
                .getElementById("navbar-nav")
                .setAttribute("data-simplebar", ""),
            document.getElementById("scrollbar").classList.add("h-100")),
            "twocolumn" ==
                document.documentElement.getAttribute("data-layout") &&
                (document
                    .getElementById("scrollbar")
                    .removeAttribute("data-simplebar"),
                document.getElementById("scrollbar").classList.remove("h-100")),
            "horizontal" ==
                document.documentElement.getAttribute("data-layout") && x();
    }
    function i() {
        feather.replace();
        var a = document.documentElement.clientWidth;
        a < 1025 && 767 < a
            ? (document.body.classList.remove("twocolumn-panel"),
              "twocolumn" == sessionStorage.getItem("data-layout") &&
                  (document.documentElement.setAttribute(
                      "data-layout",
                      "twocolumn"
                  ),
                  document.getElementById("customizer-layout03") &&
                      document.getElementById("customizer-layout03").click(),
                  o(),
                  v(),
                  n()),
              "vertical" == sessionStorage.getItem("data-layout") &&
                  document.documentElement.setAttribute(
                      "data-sidebar-size",
                      "sm"
                  ),
              document.querySelector(".hamburger-icon").classList.add("open"))
            : 1025 <= a
            ? (document.body.classList.remove("twocolumn-panel"),
              "twocolumn" == sessionStorage.getItem("data-layout") &&
                  (document.documentElement.setAttribute(
                      "data-layout",
                      "twocolumn"
                  ),
                  document.getElementById("customizer-layout03") &&
                      document.getElementById("customizer-layout03").click(),
                  o(),
                  v(),
                  n()),
              "vertical" == sessionStorage.getItem("data-layout") &&
                  document.documentElement.setAttribute(
                      "data-sidebar-size",
                      sessionStorage.getItem("data-sidebar-size")
                  ),
              document
                  .querySelector(".hamburger-icon")
                  .classList.remove("open"))
            : a <= 767 &&
              (document.body.classList.remove("vertical-sidebar-enable"),
              document.body.classList.add("twocolumn-panel"),
              "twocolumn" == sessionStorage.getItem("data-layout") &&
                  (document.documentElement.setAttribute(
                      "data-layout",
                      "vertical"
                  ),
                  y("vertical"),
                  n()),
              "horizontal" != sessionStorage.getItem("data-layout") &&
                  document.documentElement.setAttribute(
                      "data-sidebar-size",
                      "lg"
                  ),
              document.querySelector(".hamburger-icon").classList.add("open")),
            document
                .querySelectorAll("#navbar-nav > li.nav-item")
                .forEach(function (a) {
                    a.addEventListener("click", u.bind(this), !1),
                        a.addEventListener("mouseover", u.bind(this), !1);
                });
    }
    function u(a) {
        if (a.target && a.target.matches("a.nav-link span")) {
            if (0 == p(a.target.parentElement.nextElementSibling))
                a.target.parentElement.nextElementSibling.classList.add(
                    "dropdown-custom-right"
                ),
                    a.target.parentElement.parentElement.parentElement.parentElement.classList.add(
                        "dropdown-custom-right"
                    ),
                    a.target.parentElement.nextElementSibling
                        .querySelectorAll(".menu-dropdown")
                        .forEach(function (a) {
                            a.classList.add("dropdown-custom-right");
                        });
            else if (
                1 == p(a.target.parentElement.nextElementSibling) &&
                1848 <= window.innerWidth
            )
                for (
                    var b = document.getElementsByClassName(
                        "dropdown-custom-right"
                    );
                    0 < b.length;

                )
                    b[0].classList.remove("dropdown-custom-right");
        }
        if (a.target && a.target.matches("a.nav-link")) {
            if (0 == p(a.target.nextElementSibling))
                a.target.nextElementSibling.classList.add(
                    "dropdown-custom-right"
                ),
                    a.target.parentElement.parentElement.parentElement.classList.add(
                        "dropdown-custom-right"
                    ),
                    a.target.nextElementSibling
                        .querySelectorAll(".menu-dropdown")
                        .forEach(function (a) {
                            a.classList.add("dropdown-custom-right");
                        });
            else if (
                1 == p(a.target.nextElementSibling) &&
                1848 <= window.innerWidth
            )
                for (
                    b = document.getElementsByClassName(
                        "dropdown-custom-right"
                    );
                    0 < b.length;

                )
                    b[0].classList.remove("dropdown-custom-right");
        }
    }
    function v() {
        feather.replace();
        var b,
            a =
                "/" == location.pathname
                    ? "index.html"
                    : location.pathname.substring(1);
        (a = a.substring(a.lastIndexOf("/") + 1)) &&
            ((b = document
                .getElementById("navbar-nav")
                .querySelector('[href="' + a + '"]'))
                ? (b.classList.add("active"),
                  (a =
                      (a = b.closest(".collapse.menu-dropdown")) &&
                      a.parentElement.closest(".collapse.menu-dropdown")
                          ? (a.classList.add("show"),
                            a.parentElement.children[0].classList.add("active"),
                            a.parentElement
                                .closest(".collapse.menu-dropdown")
                                .parentElement.classList.add(
                                    "twocolumn-item-show"
                                ),
                            a.parentElement
                                .closest(".collapse.menu-dropdown")
                                .getAttribute("id"))
                          : (b
                                .closest(".collapse.menu-dropdown")
                                .parentElement.classList.add(
                                    "twocolumn-item-show"
                                ),
                            a.getAttribute("id"))),
                  document
                      .getElementById("two-column-menu")
                      .querySelector('[href="#' + a + '"]') &&
                      document
                          .getElementById("two-column-menu")
                          .querySelector('[href="#' + a + '"]')
                          .classList.add("active"))
                : document.body.classList.add("twocolumn-panel"));
    }
    function w() {
        var a =
            "/" == location.pathname
                ? "index.html"
                : location.pathname.substring(1);
        !(a = a.substring(a.lastIndexOf("/") + 1)) ||
            ((a = document
                .getElementById("navbar-nav")
                .querySelector('[href="' + a + '"]')) &&
                (a.classList.add("active"),
                (a = a.closest(".collapse.menu-dropdown")) &&
                    (a.classList.add("show"),
                    a.parentElement.children[0].classList.add("active"),
                    a.parentElement.children[0].setAttribute(
                        "aria-expanded",
                        "true"
                    ),
                    a.parentElement.closest(".collapse.menu-dropdown") &&
                        (a.parentElement
                            .closest(".collapse")
                            .classList.add("show"),
                        a.parentElement.closest(".collapse")
                            .previousElementSibling &&
                            a.parentElement
                                .closest(".collapse")
                                .previousElementSibling.classList.add(
                                    "active"
                                )))));
    }
    function p(a) {
        if (a) {
            var b = a.offsetTop,
                c = a.offsetLeft,
                d = a.offsetWidth,
                e = a.offsetHeight;
            if (a.offsetParent)
                for (; a.offsetParent; )
                    (b += (a = a.offsetParent).offsetTop), (c += a.offsetLeft);
            return (
                b >= window.pageYOffset &&
                c >= window.pageXOffset &&
                b + e <= window.pageYOffset + window.innerHeight &&
                c + d <= window.pageXOffset + window.innerWidth
            );
        }
    }
    function x() {
        (document.getElementById("two-column-menu").innerHTML = ""),
            (document.querySelector(".navbar-menu").innerHTML = t),
            document
                .getElementById("scrollbar")
                .removeAttribute("data-simplebar"),
            document
                .getElementById("navbar-nav")
                .removeAttribute("data-simplebar"),
            document.getElementById("scrollbar").classList.remove("h-100");
        var a = document.querySelectorAll("ul.navbar-nav > li.nav-item"),
            b = "",
            c = "";
        a.forEach(function (d, e) {
            e + 1 === 7 && (c = d),
                7 < e + 1 && ((b += d.outerHTML), d.remove()),
                e + 1 === a.length &&
                    c.insertAdjacentHTML &&
                    c.insertAdjacentHTML(
                        "afterend",
                        '<li class="nav-item">                <a class="nav-link" href="#sidebarMore" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarMore">                    <i class="ri-briefcase-2-line"></i> More                </a>                <div class="collapse menu-dropdown" id="sidebarMore">             <ul class="nav nav-sm flex-column">' +
                            b +
                            "</ul></div></li>"
                    );
        });
    }
    function y(a) {
        "vertical" == a
            ? ((document.getElementById("two-column-menu").innerHTML = ""),
              (document.querySelector(".navbar-menu").innerHTML = t),
              document.getElementById("theme-settings-offcanvas") &&
                  ((document.getElementById("sidebar-size").style.display =
                      "block"),
                  (document.getElementById("sidebar-view").style.display =
                      "block"),
                  (document.getElementById("sidebar-color").style.display =
                      "block"),
                  (document.getElementById("layout-position").style.display =
                      "block"),
                  (document.getElementById("layout-width").style.display =
                      "block")),
              q(),
              w(),
              z())
            : "horizontal" == a
            ? (x(),
              document.getElementById("theme-settings-offcanvas") &&
                  ((document.getElementById("sidebar-size").style.display =
                      "none"),
                  (document.getElementById("sidebar-view").style.display =
                      "none"),
                  (document.getElementById("sidebar-color").style.display =
                      "none"),
                  (document.getElementById("layout-position").style.display =
                      "block"),
                  (document.getElementById("layout-width").style.display =
                      "block")),
              w())
            : "twocolumn" == a &&
              (document
                  .getElementById("scrollbar")
                  .removeAttribute("data-simplebar"),
              document.getElementById("scrollbar").classList.remove("h-100"),
              document.getElementById("theme-settings-offcanvas") &&
                  ((document.getElementById("sidebar-size").style.display =
                      "none"),
                  (document.getElementById("sidebar-view").style.display =
                      "none"),
                  (document.getElementById("sidebar-color").style.display =
                      "block"),
                  (document.getElementById("layout-position").style.display =
                      "none"),
                  (document.getElementById("layout-width").style.display =
                      "none")));
    }
    function z() {
        document
            .getElementById("vertical-hover")
            .addEventListener("click", function () {
                "sm-hover" ===
                document.documentElement.getAttribute("data-sidebar-size")
                    ? document.documentElement.setAttribute(
                          "data-sidebar-size",
                          "sm-hover-active"
                      )
                    : (document.documentElement.getAttribute(
                          "data-sidebar-size"
                      ),
                      document.documentElement.setAttribute(
                          "data-sidebar-size",
                          "sm-hover"
                      ));
            });
    }
    function j(a) {
        if (a == a) {
            switch (a["data-layout"]) {
                case "vertical":
                    A("data-layout", "vertical"),
                        sessionStorage.setItem("data-layout", "vertical"),
                        document.documentElement.setAttribute(
                            "data-layout",
                            "vertical"
                        ),
                        y("vertical"),
                        n();
                    break;
                case "horizontal":
                    A("data-layout", "horizontal"),
                        sessionStorage.setItem("data-layout", "horizontal"),
                        document.documentElement.setAttribute(
                            "data-layout",
                            "horizontal"
                        ),
                        y("horizontal");
                    break;
                case "twocolumn":
                    A("data-layout", "twocolumn"),
                        sessionStorage.setItem("data-layout", "twocolumn"),
                        document.documentElement.setAttribute(
                            "data-layout",
                            "twocolumn"
                        ),
                        y("twocolumn");
                    break;
                default:
                    "vertical" == sessionStorage.getItem("data-layout") &&
                    sessionStorage.getItem("data-layout")
                        ? (A("data-layout", "vertical"),
                          sessionStorage.setItem("data-layout", "vertical"),
                          document.documentElement.setAttribute(
                              "data-layout",
                              "vertical"
                          ),
                          y("vertical"),
                          n())
                        : "horizontal" == sessionStorage.getItem("data-layout")
                        ? (A("data-layout", "horizontal"),
                          sessionStorage.setItem("data-layout", "horizontal"),
                          document.documentElement.setAttribute(
                              "data-layout",
                              "horizontal"
                          ),
                          y("horizontal"))
                        : "twocolumn" ==
                              sessionStorage.getItem("data-layout") &&
                          (A("data-layout", "twocolumn"),
                          sessionStorage.setItem("data-layout", "twocolumn"),
                          document.documentElement.setAttribute(
                              "data-layout",
                              "twocolumn"
                          ),
                          y("twocolumn"));
            }
            switch (a["data-topbar"]) {
                case "light":
                    A("data-topbar", "light"),
                        sessionStorage.setItem("data-topbar", "light"),
                        document.documentElement.setAttribute(
                            "data-topbar",
                            "light"
                        );
                    break;
                case "dark":
                    A("data-topbar", "dark"),
                        sessionStorage.setItem("data-topbar", "dark"),
                        document.documentElement.setAttribute(
                            "data-topbar",
                            "dark"
                        );
                    break;
                default:
                    "dark" == sessionStorage.getItem("data-topbar")
                        ? (A("data-topbar", "dark"),
                          sessionStorage.setItem("data-topbar", "dark"),
                          document.documentElement.setAttribute(
                              "data-topbar",
                              "dark"
                          ))
                        : (A("data-topbar", "light"),
                          sessionStorage.setItem("data-topbar", "light"),
                          document.documentElement.setAttribute(
                              "data-topbar",
                              "light"
                          ));
            }
            switch (a["data-layout-style"]) {
                case "default":
                    A("data-layout-style", "default"),
                        sessionStorage.setItem("data-layout-style", "default"),
                        document.documentElement.setAttribute(
                            "data-layout-style",
                            "default"
                        );
                    break;
                case "detached":
                    A("data-layout-style", "detached"),
                        sessionStorage.setItem("data-layout-style", "detached"),
                        document.documentElement.setAttribute(
                            "data-layout-style",
                            "detached"
                        );
                    break;
                default:
                    "detached" == sessionStorage.getItem("data-layout-style")
                        ? (A("data-layout-style", "detached"),
                          sessionStorage.setItem(
                              "data-layout-style",
                              "detached"
                          ),
                          document.documentElement.setAttribute(
                              "data-layout-style",
                              "detached"
                          ))
                        : (A("data-layout-style", "default"),
                          sessionStorage.setItem(
                              "data-layout-style",
                              "default"
                          ),
                          document.documentElement.setAttribute(
                              "data-layout-style",
                              "default"
                          ));
            }
            switch (a["data-sidebar-size"]) {
                case "lg":
                    A("data-sidebar-size", "lg"),
                        document.documentElement.setAttribute(
                            "data-sidebar-size",
                            "lg"
                        ),
                        sessionStorage.setItem("data-sidebar-size", "lg");
                    break;
                case "sm":
                    A("data-sidebar-size", "sm"),
                        document.documentElement.setAttribute(
                            "data-sidebar-size",
                            "sm"
                        ),
                        sessionStorage.setItem("data-sidebar-size", "sm");
                    break;
                case "md":
                    A("data-sidebar-size", "md"),
                        document.documentElement.setAttribute(
                            "data-sidebar-size",
                            "md"
                        ),
                        sessionStorage.setItem("data-sidebar-size", "md");
                    break;
                case "sm-hover":
                    A("data-sidebar-size", "sm-hover"),
                        document.documentElement.setAttribute(
                            "data-sidebar-size",
                            "sm-hover"
                        ),
                        sessionStorage.setItem("data-sidebar-size", "sm-hover");
                    break;
                default:
                    "sm" == sessionStorage.getItem("data-sidebar-size")
                        ? (document.documentElement.setAttribute(
                              "data-sidebar-size",
                              "sm"
                          ),
                          A("data-sidebar-size", "sm"),
                          sessionStorage.setItem("data-sidebar-size", "sm"))
                        : "md" == sessionStorage.getItem("data-sidebar-size")
                        ? (document.documentElement.setAttribute(
                              "data-sidebar-size",
                              "md"
                          ),
                          A("data-sidebar-size", "md"),
                          sessionStorage.setItem("data-sidebar-size", "md"))
                        : "sm-hover" ==
                          sessionStorage.getItem("data-sidebar-size")
                        ? (document.documentElement.setAttribute(
                              "data-sidebar-size",
                              "sm-hover"
                          ),
                          A("data-sidebar-size", "sm-hover"),
                          sessionStorage.setItem(
                              "data-sidebar-size",
                              "sm-hover"
                          ))
                        : (document.documentElement.setAttribute(
                              "data-sidebar-size",
                              "lg"
                          ),
                          A("data-sidebar-size", "lg"),
                          sessionStorage.setItem("data-sidebar-size", "lg"));
            }
            switch (a["data-layout-mode"]) {
                case "light":
                    A("data-layout-mode", "light"),
                        document.documentElement.setAttribute(
                            "data-layout-mode",
                            "light"
                        ),
                        sessionStorage.setItem("data-layout-mode", "light");
                    break;
                case "dark":
                    A("data-layout-mode", "dark"),
                        document.documentElement.setAttribute(
                            "data-layout-mode",
                            "dark"
                        ),
                        sessionStorage.setItem("data-layout-mode", "dark");
                    break;
                default:
                    sessionStorage.getItem("data-layout-mode") &&
                    "dark" == sessionStorage.getItem("data-layout-mode")
                        ? (sessionStorage.setItem("data-layout-mode", "dark"),
                          document.documentElement.setAttribute(
                              "data-layout-mode",
                              "dark"
                          ),
                          A("data-layout-mode", "dark"))
                        : (sessionStorage.setItem("data-layout-mode", "light"),
                          document.documentElement.setAttribute(
                              "data-layout-mode",
                              "light"
                          ),
                          A("data-layout-mode", "light"));
            }
            switch (a["data-layout-width"]) {
                case "fluid":
                    A("data-layout-width", "fluid"),
                        document.documentElement.setAttribute(
                            "data-layout-width",
                            "fluid"
                        ),
                        sessionStorage.setItem("data-layout-width", "fluid");
                    break;
                case "boxed":
                    A("data-layout-width", "boxed"),
                        document.documentElement.setAttribute(
                            "data-layout-width",
                            "boxed"
                        ),
                        sessionStorage.setItem("data-layout-width", "boxed");
                    break;
                default:
                    "boxed" == sessionStorage.getItem("data-layout-width")
                        ? (sessionStorage.setItem("data-layout-width", "boxed"),
                          document.documentElement.setAttribute(
                              "data-layout-width",
                              "boxed"
                          ),
                          A("data-layout-width", "boxed"))
                        : (sessionStorage.setItem("data-layout-width", "fluid"),
                          document.documentElement.setAttribute(
                              "data-layout-width",
                              "fluid"
                          ),
                          A("data-layout-width", "fluid"));
            }
            switch (a["data-sidebar"]) {
                case "light":
                    A("data-sidebar", "light"),
                        sessionStorage.setItem("data-sidebar", "light"),
                        document.documentElement.setAttribute(
                            "data-sidebar",
                            "light"
                        );
                    break;
                case "dark":
                    A("data-sidebar", "dark"),
                        sessionStorage.setItem("data-sidebar", "dark"),
                        document.documentElement.setAttribute(
                            "data-sidebar",
                            "dark"
                        );
                    break;
                default:
                    sessionStorage.getItem("data-sidebar") &&
                    "light" == sessionStorage.getItem("data-sidebar")
                        ? (sessionStorage.setItem("data-sidebar", "light"),
                          A("data-sidebar", "light"),
                          document.documentElement.setAttribute(
                              "data-sidebar",
                              "light"
                          ))
                        : (sessionStorage.setItem("data-sidebar", "dark"),
                          A("data-sidebar", "dark"),
                          document.documentElement.setAttribute(
                              "data-sidebar",
                              "dark"
                          ));
            }
            switch (a["data-layout-position"]) {
                case "fixed":
                    A("data-layout-position", "fixed"),
                        sessionStorage.setItem("data-layout-position", "fixed"),
                        document.documentElement.setAttribute(
                            "data-layout-position",
                            "fixed"
                        );
                    break;
                case "scrollable":
                    A("data-layout-position", "scrollable"),
                        sessionStorage.setItem(
                            "data-layout-position",
                            "scrollable"
                        ),
                        document.documentElement.setAttribute(
                            "data-layout-position",
                            "scrollable"
                        );
                    break;
                default:
                    sessionStorage.getItem("data-layout-position") &&
                    "scrollable" ==
                        sessionStorage.getItem("data-layout-position")
                        ? (A("data-layout-position", "scrollable"),
                          sessionStorage.setItem(
                              "data-layout-position",
                              "scrollable"
                          ),
                          document.documentElement.setAttribute(
                              "data-layout-position",
                              "scrollable"
                          ))
                        : (A("data-layout-position", "fixed"),
                          sessionStorage.setItem(
                              "data-layout-position",
                              "fixed"
                          ),
                          document.documentElement.setAttribute(
                              "data-layout-position",
                              "fixed"
                          ));
            }
        }
    }
    function A(a, b) {
        document
            .querySelectorAll("input[name=" + a + "]")
            .forEach(function (c) {
                b == c.value ? (c.checked = !0) : (c.checked = !1),
                    c.addEventListener("change", function () {
                        document.documentElement.setAttribute(a, c.value),
                            sessionStorage.setItem(a, c.value),
                            "data-layout-width" == a && "boxed" == c.value
                                ? (document.documentElement.setAttribute(
                                      "data-sidebar-size",
                                      "sm-hover"
                                  ),
                                  sessionStorage.setItem(
                                      "data-sidebar-size",
                                      "sm-hover"
                                  ),
                                  (document.getElementById(
                                      "sidebar-size-small-hover"
                                  ).checked = !0))
                                : "data-layout-width" == a &&
                                  "fluid" == c.value &&
                                  (document.documentElement.setAttribute(
                                      "data-sidebar-size",
                                      "lg"
                                  ),
                                  sessionStorage.setItem(
                                      "data-sidebar-size",
                                      "lg"
                                  ),
                                  (document.getElementById(
                                      "sidebar-size-default"
                                  ).checked = !0)),
                            "data-layout" == a &&
                                ("vertical" == c.value
                                    ? (y("vertical"), n(), feather.replace())
                                    : "horizontal" == c.value
                                    ? (y("horizontal"), feather.replace())
                                    : "twocolumn" == c.value &&
                                      (y("twocolumn"),
                                      document.documentElement.setAttribute(
                                          "data-layout-width",
                                          "fluid"
                                      ),
                                      document
                                          .getElementById("layout-width-fluid")
                                          .click(),
                                      o(),
                                      v(),
                                      n(),
                                      feather.replace()));
                    });
            });
    }
    function B(b, c, a, d) {
        var e = document.getElementById(a);
        d.setAttribute(b, c), e && document.getElementById(a).click();
    }
    function f() {
        document.webkitIsFullScreen ||
            document.mozFullScreen ||
            document.msFullscreenElement ||
            document.body.classList.remove("fullscreen-enable");
    }
    function C() {
        "horizontal" !== document.documentElement.getAttribute("data-layout") &&
            (document.getElementById("navbar-nav") &&
                new SimpleBar(
                    document.getElementById("navbar-nav")
                ).getContentElement(),
            document.getElementsByClassName("twocolumn-iconview")[0] &&
                new SimpleBar(
                    document.getElementsByClassName("twocolumn-iconview")[0]
                ).getContentElement(),
            clearTimeout(s));
    }
    sessionStorage.getItem("defaultAttribute")
        ? (((a = {})["data-layout"] = sessionStorage.getItem("data-layout")),
          (a["data-sidebar-size"] =
              sessionStorage.getItem("data-sidebar-size")),
          (a["data-layout-mode"] = sessionStorage.getItem("data-layout-mode")),
          (a["data-layout-width"] =
              sessionStorage.getItem("data-layout-width")),
          (a["data-sidebar"] = sessionStorage.getItem("data-sidebar")),
          (a["data-layout-position"] = sessionStorage.getItem(
              "data-layout-position"
          )),
          (a["data-layout-style"] =
              sessionStorage.getItem("data-layout-style")),
          (a["data-topbar"] = sessionStorage.getItem("data-topbar")),
          j(a))
        : ((b = document.documentElement.attributes),
          (a = {}),
          b.forEach(function (b) {
              var c;
              b &&
                  b.nodeName &&
                  "undefined" != b.nodeName &&
                  ((a[(c = b.nodeName)] = b.nodeValue),
                  sessionStorage.setItem(c, b.nodeValue));
          }),
          sessionStorage.setItem("defaultAttribute", JSON.stringify(a)),
          j(a),
          (b = document.querySelector(
              '.btn[data-bs-target="#theme-settings-offcanvas"]'
          )) && b.click()),
        o(),
        (h = document.getElementById("search-close-options")),
        (k = document.getElementById("search-dropdown")),
        h.addEventListener("click", function () {
            (r.value = ""),
                k.classList.remove("show"),
                h.classList.add("d-none");
        }),
        (b = document.querySelector('[data-toggle="fullscreen"]')) &&
            b.addEventListener("click", function (a) {
                a.preventDefault(),
                    document.body.classList.toggle("fullscreen-enable"),
                    document.fullscreenElement ||
                    document.mozFullScreenElement ||
                    document.webkitFullscreenElement
                        ? document.cancelFullScreen
                            ? document.cancelFullScreen()
                            : document.mozCancelFullScreen
                            ? document.mozCancelFullScreen()
                            : document.webkitCancelFullScreen &&
                              document.webkitCancelFullScreen()
                        : document.documentElement.requestFullscreen
                        ? document.documentElement.requestFullscreen()
                        : document.documentElement.mozRequestFullScreen
                        ? document.documentElement.mozRequestFullScreen()
                        : document.documentElement.webkitRequestFullscreen &&
                          document.documentElement.webkitRequestFullscreen(
                              Element.ALLOW_KEYBOARD_INPUT
                          );
            }),
        document.addEventListener("fullscreenchange", f),
        document.addEventListener("webkitfullscreenchange", f),
        document.addEventListener("mozfullscreenchange", f),
        (l = document.getElementsByTagName("HTML")[0]),
        (b = document.querySelectorAll(".light-dark-mode")) &&
            b.length &&
            b[0].addEventListener("click", function (a) {
                l.hasAttribute("data-layout-mode") &&
                "dark" == l.getAttribute("data-layout-mode")
                    ? B("data-layout-mode", "light", "layout-mode-light", l)
                    : B("data-layout-mode", "dark", "layout-mode-dark", l);
            }),
        document.addEventListener("DOMContentLoaded", function () {
            document
                .getElementsByClassName("code-switcher")
                .forEach(function (a, b) {
                    a.addEventListener("change", function () {
                        var b = a.closest(".card"),
                            c = b.querySelector(".live-preview"),
                            b = b.querySelector(".code-view");
                        a.checked
                            ? (c.classList.add("d-none"),
                              b.classList.remove("d-none"))
                            : (c.classList.remove("d-none"),
                              b.classList.add("d-none"));
                    });
                }),
                feather.replace();
        }),
        window.addEventListener("resize", i),
        i(),
        // comment 1 : Waves.init(),
        document.addEventListener("scroll", function () {
            var a;
            (a = document.getElementById("page-topbar")),
                50 <= document.body.scrollTop ||
                50 <= document.documentElement.scrollTop
                    ? a.classList.add("topbar-shadow")
                    : a.classList.remove("topbar-shadow");
        }),
        window.addEventListener("load", function () {
            var a;
            ("twocolumn" == document.documentElement.getAttribute("data-layout")
                ? v
                : w)(),
                (a = document.getElementsByClassName("vertical-overlay")) &&
                    a.forEach(function (a) {
                        a.addEventListener("click", function () {
                            document.body.classList.remove(
                                "vertical-sidebar-enable"
                            ),
                                "twocolumn" ==
                                sessionStorage.getItem("data-layout")
                                    ? document.body.classList.add(
                                          "twocolumn-panel"
                                      )
                                    : document.documentElement.setAttribute(
                                          "data-sidebar-size",
                                          sessionStorage.getItem(
                                              "data-sidebar-size"
                                          )
                                      );
                        });
                    }),
                z();
        }),
        document
            .getElementById("topnav-hamburger-icon")
            .addEventListener("click", function () {
                var a = document.documentElement.clientWidth;
                767 < a &&
                    document
                        .querySelector(".hamburger-icon")
                        .classList.toggle("open"),
                    "horizontal" ===
                        document.documentElement.getAttribute("data-layout") &&
                        (document.body.classList.contains("menu")
                            ? document.body.classList.remove("menu")
                            : document.body.classList.add("menu")),
                    "vertical" ===
                        document.documentElement.getAttribute("data-layout") &&
                        (a < 1025 && 767 < a
                            ? (document.body.classList.remove(
                                  "vertical-sidebar-enable"
                              ),
                              "sm" ==
                              document.documentElement.getAttribute(
                                  "data-sidebar-size"
                              )
                                  ? document.documentElement.setAttribute(
                                        "data-sidebar-size",
                                        ""
                                    )
                                  : document.documentElement.setAttribute(
                                        "data-sidebar-size",
                                        "sm"
                                    ))
                            : 1025 < a
                            ? (document.body.classList.remove(
                                  "vertical-sidebar-enable"
                              ),
                              "lg" ==
                              document.documentElement.getAttribute(
                                  "data-sidebar-size"
                              )
                                  ? document.documentElement.setAttribute(
                                        "data-sidebar-size",
                                        "sm"
                                    )
                                  : document.documentElement.setAttribute(
                                        "data-sidebar-size",
                                        "lg"
                                    ))
                            : a <= 767 &&
                              (document.body.classList.add(
                                  "vertical-sidebar-enable"
                              ),
                              document.documentElement.setAttribute(
                                  "data-sidebar-size",
                                  "lg"
                              ))),
                    "twocolumn" ==
                        document.documentElement.getAttribute("data-layout") &&
                        (document.body.classList.contains("twocolumn-panel")
                            ? document.body.classList.remove("twocolumn-panel")
                            : document.body.classList.add("twocolumn-panel"));
            }),
        (c = sessionStorage.getItem("defaultAttribute")),
        (g = JSON.parse(c)),
        (c = document.documentElement.clientWidth),
        "twocolumn" == g["data-layout"] &&
            c < 767 &&
            document
                .getElementById("two-column-menu")
                .querySelectorAll("li")
                .forEach(function (a) {
                    a.addEventListener("click", function (a) {
                        document.body.classList.remove("twocolumn-panel");
                    });
                }),
        (function () {
            var a = document.querySelectorAll(".counter-value");
            function b(a) {
                return a.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }
            a &&
                a.forEach(function (a) {
                    !(function f() {
                        var c = +a.getAttribute("data-target"),
                            e = +a.innerText,
                            d = c / 250;
                        d < 1 && (d = 1),
                            e < c
                                ? ((a.innerText = (e + d).toFixed(0)),
                                  setTimeout(f, 1))
                                : (a.innerText = b(c)),
                            b(a.innerText);
                    })();
                });
        })(),
        q(),
        document.getElementById("reset-layout") &&
            document
                .getElementById("reset-layout")
                .addEventListener("click", function () {
                    sessionStorage.clear(), window.location.reload();
                }),
        document.querySelectorAll("[data-toast]").forEach(function (a) {
            a.addEventListener("click", function () {
                var b = {},
                    c = a.attributes;
                c["data-toast-text"] &&
                    (b.text = c["data-toast-text"].value.toString()),
                    c["data-toast-gravity"] &&
                        (b.gravity = c["data-toast-gravity"].value.toString()),
                    c["data-toast-position"] &&
                        (b.position =
                            c["data-toast-position"].value.toString()),
                    c["data-toast-className"] &&
                        (b.className =
                            c["data-toast-className"].value.toString()),
                    c["data-toast-duration"] &&
                        (b.duration =
                            c["data-toast-duration"].value.toString()),
                    c["data-toast-close"] &&
                        (b.close = c["data-toast-close"].value.toString()),
                    c["data-toast-style"] &&
                        (b.style = c["data-toast-style"].value.toString()),
                    c["data-toast-offset"] &&
                        (b.offset = c["data-toast-offset"]),
                    Toastify({
                        newWindow: !0,
                        text: b.text,
                        gravity: b.gravity,
                        position: b.position,
                        className: "bg-" + b.className,
                        stopOnFocus: !0,
                        offset: { x: b.offset ? 50 : 0, y: b.offset ? 10 : 0 },
                        duration: b.duration,
                        close: "close" == b.close,
                        style:
                            "style" == b.style
                                ? {
                                      background:
                                          "linear-gradient(to right, #0AB39C, #405189)",
                                  }
                                : "",
                    }).showToast();
            });
        }),
        document.querySelectorAll("[data-choices]").forEach(function (c) {
            var b = {},
                a = c.attributes;
            a["data-choices-groups"] &&
                (b.placeholderValue =
                    "This is a placeholder set in the config"),
                a["data-choices-search-false"] && (b.searchEnabled = !1),
                a["data-choices-search-true"] && (b.searchEnabled = !0),
                a["data-choices-removeItem"] && (b.removeItemButton = !0),
                a["data-choices-sorting-false"] && (b.shouldSort = !1),
                a["data-choices-sorting-true"] && (b.shouldSort = !0),
                a["data-choices-multiple-default"],
                a["data-choices-multiple-groups"],
                a["data-choices-multiple-remove"] && (b.removeItemButton = !0),
                a["data-choices-limit"] &&
                    (b.maxItemCount = a["data-choices-limit"].value.toString()),
                a["data-choices-limit"] &&
                    (b.maxItemCount = a["data-choices-limit"].value.toString()),
                a["data-choices-editItem-true"] && (b.maxItemCount = !0),
                a["data-choices-editItem-false"] && (b.maxItemCount = !1),
                a["data-choices-text-unique-true"] &&
                    (b.duplicateItemsAllowed = !1),
                a["data-choices-text-disabled-true"] && (b.addItems = !1),
                a["data-choices-text-disabled-true"]
                    ? new Choices(c, b).disable()
                    : new Choices(c, b);
        }),
        document.querySelectorAll("[data-provider]").forEach(function (d) {
            var c, b, a;
            "flatpickr" == d.getAttribute("data-provider")
                ? ((a = {}),
                  (c = d.attributes)["data-date-format"] &&
                      (a.dateFormat = c["data-date-format"].value.toString()),
                  c["data-enable-time"] &&
                      ((a.enableTime = !0),
                      (a.dateFormat =
                          c["data-date-format"].value.toString() + " H:i")),
                  c["data-altFormat"] &&
                      ((a.altInput = !0),
                      (a.altFormat = c["data-altFormat"].value.toString())),
                  c["data-minDate"] &&
                      ((a.minDate = c["data-minDate"].value.toString()),
                      (a.dateFormat = c["data-date-format"].value.toString())),
                  c["data-maxDate"] &&
                      ((a.maxDate = c["data-maxDate"].value.toString()),
                      (a.dateFormat = c["data-date-format"].value.toString())),
                  c["data-deafult-date"] &&
                      ((a.defaultDate =
                          c["data-deafult-date"].value.toString()),
                      (a.dateFormat = c["data-date-format"].value.toString())),
                  c["data-multiple-date"] &&
                      ((a.mode = "multiple"),
                      (a.dateFormat = c["data-date-format"].value.toString())),
                  c["data-range-date"] &&
                      ((a.mode = "range"),
                      (a.dateFormat = c["data-date-format"].value.toString())),
                  c["data-inline-date"] &&
                      ((a.inline = !0),
                      (a.defaultDate = c["data-deafult-date"].value.toString()),
                      (a.dateFormat = c["data-date-format"].value.toString())),
                  c["data-disable-date"] &&
                      ((b = []).push(c["data-disable-date"].value),
                      (a.disable = b.toString().split(","))),
                  flatpickr(d, a))
                : "timepickr" == d.getAttribute("data-provider") &&
                  ((b = {}),
                  (a = d.attributes)["data-time-basic"] &&
                      ((b.enableTime = !0),
                      (b.noCalendar = !0),
                      (b.dateFormat = "H:i")),
                  a["data-time-hrs"] &&
                      ((b.enableTime = !0),
                      (b.noCalendar = !0),
                      (b.dateFormat = "H:i"),
                      (b.time_24hr = !0)),
                  a["data-min-time"] &&
                      ((b.enableTime = !0),
                      (b.noCalendar = !0),
                      (b.dateFormat = "H:i"),
                      (b.minTime = a["data-min-time"].value.toString())),
                  a["data-max-time"] &&
                      ((b.enableTime = !0),
                      (b.noCalendar = !0),
                      (b.dateFormat = "H:i"),
                      (b.minTime = a["data-max-time"].value.toString())),
                  a["data-default-time"] &&
                      ((b.enableTime = !0),
                      (b.noCalendar = !0),
                      (b.dateFormat = "H:i"),
                      (b.defaultDate =
                          a["data-default-time"].value.toString())),
                  a["data-time-inline"] &&
                      ((b.enableTime = !0),
                      (b.noCalendar = !0),
                      (b.defaultDate = a["data-time-inline"].value.toString()),
                      (b.inline = !0)),
                  flatpickr(d, b));
        }),
        document
            .querySelectorAll('.dropdown-menu a[data-bs-toggle="tab"]')
            .forEach(function (a) {
                a.addEventListener("click", function (a) {
                    a.stopPropagation(),
                        bootstrap.Tab.getInstance(a.target).show();
                });
            }),
        "null" != e && "en" !== e && m(e),
        (d = document.getElementsByClassName("language")),
        d &&
            d.forEach(function (a) {
                a.addEventListener("click", function (b) {
                    m(a.getAttribute("data-lang"));
                });
            }),
        n(),
        window.addEventListener("resize", function () {
            s && clearTimeout(s), (s = setTimeout(C, 2e3));
        });
})();
