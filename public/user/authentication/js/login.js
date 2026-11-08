
  document.querySelectorAll('a[data-bs-toggle="tab"]').forEach(a=>{
    a.addEventListener('click', function (e) {
      e.preventDefault();
      const target = (this.getAttribute('data-bs-target') || this.getAttribute('href')).replace('#','');
      const tabBtn = document.getElementById(target + '-tab'); // e.g. signup -> signup-tab
      if (tabBtn) {
        const tab = new bootstrap.Tab(tabBtn);
        tab.show();
      }
    });
  });

