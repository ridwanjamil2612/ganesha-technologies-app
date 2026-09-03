(function () {
    const box = document.querySelector('.seo-live');
    if (!box) return;

    const form = box.closest('form');
    const d = box.dataset;
    const kwInput = box.querySelector('.seo-kw');
    const numEl = box.querySelector('.seo-live-num');
    const badge = box.querySelector('.seo-live-badge');
    const list = box.querySelector('.seo-live-list');

    const field = (name) => (name ? form.querySelector('[name="' + name + '"]') : null);
    const val = (name) => {
        const el = field(name);
        return el ? el.value.trim() : '';
    };
    const slugify = (s) => s.toLowerCase().trim()
        .replace(/[^a-z0-9\s-]/g, '').replace(/\s+/g, '-').replace(/-+/g, '-');

    function analyze() {
        const title = val(d.title);
        const desc = val(d.desc);
        const slug = val(d.slug);
        const content = d.content ? val(d.content) : '';
        const kw = kwInput.value.trim().toLowerCase();
        const words = content ? content.split(/\s+/).filter(Boolean).length : 0;

        const imgEl = field(d.image);
        const imageOk = d.hasImage === '1' || (imgEl && imgEl.files && imgEl.files.length > 0);

        const tMin = +d.titleMin, tMax = +d.titleMax, dMin = +d.descMin, dMax = +d.descMax, cMin = +d.contentMin;
        const checks = [];

        // Judul
        if (title.length === 0) checks.push([false, 'Judul masih kosong']);
        else if (title.length < tMin) checks.push([false, 'Judul terlalu pendek (' + title.length + ' krkt, ideal ' + tMin + '–' + tMax + ')']);
        else if (title.length > tMax) checks.push([false, 'Judul terlalu panjang (' + title.length + ' krkt, bisa terpotong di Google)']);
        else checks.push([true, 'Panjang judul pas (' + title.length + ' krkt)']);

        // Deskripsi
        if (desc.length === 0) checks.push([false, 'Deskripsi/ringkasan masih kosong']);
        else if (desc.length < dMin) checks.push([false, 'Deskripsi terlalu pendek (' + desc.length + ' krkt, ideal ' + dMin + '–' + dMax + ')']);
        else if (desc.length > dMax + 10) checks.push([false, 'Deskripsi terlalu panjang (' + desc.length + ' krkt)']);
        else checks.push([true, 'Panjang deskripsi pas (' + desc.length + ' krkt)']);

        // Gambar
        checks.push([imageOk, imageOk ? 'Gambar sudah ada' : 'Belum ada gambar']);

        // Isi (khusus yang punya content)
        if (d.content) {
            checks.push([words >= cMin, words >= cMin
                ? 'Panjang isi cukup (' + words + ' kata)'
                : 'Isi terlalu pendek (' + words + ' kata, ideal ≥' + cMin + ')']);
        }

        // Slug
        if (slug.length === 0) checks.push([true, 'Slug akan dibuat otomatis dari judul']);
        else checks.push([/^[a-z0-9-]+$/.test(slug), /^[a-z0-9-]+$/.test(slug)
            ? 'Slug rapi' : 'Slug sebaiknya huruf kecil & tanda hubung saja']);

        // Kata kunci fokus (hanya bila diisi)
        if (kw) {
            const inTitle = title.toLowerCase().includes(kw);
            const effSlug = slug || slugify(title);
            const inSlug = effSlug.includes(slugify(kw));
            const inDesc = desc.toLowerCase().includes(kw);
            checks.push([inTitle, inTitle ? 'Kata kunci ada di judul' : 'Kata kunci belum ada di judul']);
            checks.push([inSlug, inSlug ? 'Kata kunci ada di URL (slug)' : 'Kata kunci belum ada di URL (slug)']);
            checks.push([inDesc, inDesc ? 'Kata kunci ada di deskripsi' : 'Kata kunci belum ada di deskripsi']);
            if (d.content) {
                const inBody = content.toLowerCase().includes(kw);
                checks.push([inBody, inBody ? 'Kata kunci ada di isi' : 'Kata kunci belum ada di isi']);
            }
        }

        // Skor + render
        const passed = checks.filter((c) => c[0]).length;
        const score = checks.length ? Math.round(passed / checks.length * 100) : 100;
        numEl.textContent = score;
        const color = score >= 80 ? '#5A8F27' : (score >= 50 ? '#C98A1E' : '#C1492F');
        badge.style.background = color;

        list.innerHTML = '';
        checks.forEach((c) => {
            const li = document.createElement('li');
            li.className = c[0] ? 'good' : 'bad';
            li.innerHTML = '<span class="mk">' + (c[0] ? '✓' : '!') + '</span>' + c[1];
            list.appendChild(li);
        });
    }

    ['input', 'change'].forEach((ev) => form.addEventListener(ev, analyze));
    analyze();
})();
