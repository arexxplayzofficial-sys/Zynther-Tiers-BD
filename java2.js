async function savePlayer(e) {
  e.preventDefault();
  const id = document.getElementById('p_id').value;
  const username = document.getElementById('username').value.trim();
  
  const payload = {
    username: username,
    points: parseInt(document.getElementById('points').value) || 0,
    region: document.getElementById('region').value,
    vanilla: document.getElementById('vanilla').value || null,
    uhc: document.getElementById('uhc').value || null,
    pot: document.getElementById('pot').value || null,
    nethop: document.getElementById('nethop').value || null,
    smp: document.getElementById('smp').value || null,
    sword: document.getElementById('sword').value || null,
    axe: document.getElementById('axe').value || null,
    mace: document.getElementById('mace').value || null
  };

  try {
    let url = API_BASE;
    let method = 'POST';

    // Set correct structural configuration headers for Upserts/Updates
    let activeHeaders = { ...headers };
    if (id) {
      url = `${API_BASE}?username=eq.${encodeURIComponent(id)}`;
      method = 'PATCH';
    } else {
      // This tells Supabase to overwrite/upsert smoothly if a username already exists
      activeHeaders["Prefer"] = "resolution=merge-duplicates";
    }

    const res = await fetch(url, {
      method: method,
      headers: activeHeaders,
      body: JSON.stringify(payload)
    });

    if(res.ok) {
      showToast(id ? "Profile configuration modernized!" : "Competitor provisioned successfully.");
      resetForm();
      loadDirectory();
    } else {
      showToast("Transaction dismissed. Check column schema properties.", true);
    }
  } catch(err) {
    showToast("Network fault during write transaction.", true);
  }
}