
        let editing = false;
        let gender = 'Laki-laki';

        function toggleEdit() {
            editing = !editing;
            document.getElementById('viewMode').style.display = editing ? 'none' : 'flex';
            document.getElementById('editMode').style.display = editing ? 'block' : 'none';
            const btn = document.getElementById('editBtn');
            if (editing) {
                btn.innerHTML = `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="12" height="12"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg> Batal`;
                btn.classList.add('cancel');
            } else {
                btn.innerHTML = `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="12" height="12"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.12 2.12 0 013 3L12 15l-4 1 1-4z"/></svg> Edit Profil`;
                btn.classList.remove('cancel');
            }
        }

        function selectGender(val) {
            gender = val;
            document.getElementById('r-laki').classList.toggle('checked', val === 'Laki-laki');
            document.getElementById('r-perempuan').classList.toggle('checked', val === 'Perempuan');
        }

        function simpan() {
            document.getElementById('v-username').textContent = document.getElementById('e-username').value;
            document.getElementById('v-nama').textContent = document.getElementById('e-nama').value;
            document.getElementById('v-email').textContent = document.getElementById('e-email').value;
            document.getElementById('v-telepon').textContent = document.getElementById('e-telepon').value;
            const icon = gender === 'Laki-laki'
                ? `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="11" height="11"><circle cx="12" cy="9" r="5"/><path d="M12 14v7M9 18h6"/></svg>`
                : `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="11" height="11"><circle cx="12" cy="9" r="5"/><path d="M12 14v4"/><path d="M9 16.5h6"/></svg>`;
            document.getElementById('v-gender').innerHTML = icon + ' ' + gender;
            toggleEdit();
        }
    