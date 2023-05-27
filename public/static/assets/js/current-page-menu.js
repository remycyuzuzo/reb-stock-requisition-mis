/**
 * this JS script will auto highlight the active page on the menu bar by adding the 'active' class to it
 */
(function () {
    // all menu links
    const activeMenu = document.querySelectorAll(".sidebar .nav-link");
    if (!activeMenu) {
        return;
    }

    // parse the URL to extract the path of the current page
    const urlObj = new URL(document.URL)
    // 
    activeMenu.forEach(menu => {
        // parses the url in the href attr of a link
        const hrefUrlObj = new URL(menu.href)
        // if the link matches the page url, then add an active class
        if (hrefUrlObj.pathname === urlObj.pathname) {
            menu.classList.add('active');
            return;
        }
    })

    // auto-open the dropdown menu if one of its submenu is active
    const activeInSubmenu = document.querySelector(".nav-treeview a.active");
    if (activeInSubmenu) {
        activeInSubmenu.closest(".nav-treeview").previousElementSibling.classList.add("active")
        activeInSubmenu.closest('.nav-treeview').parentElement.classList.add('menu-open')
    }
})()