const API_BASE = `${SUPABASE_URL}/rest/v1`;
// Fetches from: API_BASE + '/players'
const res = await fetch(`${API_BASE}/players?select=*&...`)