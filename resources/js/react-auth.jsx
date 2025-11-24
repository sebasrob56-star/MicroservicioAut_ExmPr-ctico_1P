import React, { useState } from 'react';
import { createRoot } from 'react-dom/client';

function AuthDemo() {
  const [email, setEmail] = useState('user@example.com');
  const [password, setPassword] = useState('password123');
  const [name, setName] = useState('Demo User');
  const [role, setRole] = useState('user');
  const [token, setToken] = useState(localStorage.getItem('token') || '');
  const [me, setMe] = useState(null);
  const baseUrl = import.meta.env.VITE_BASE_URL || '';

  const api = async (path, method = 'GET', body) => {
    const res = await fetch(`${baseUrl}/api${path}`, {
      method,
      headers: {
        'Content-Type': 'application/json',
        ...(token ? { Authorization: `Bearer ${token}` } : {}),
      },
      body: body ? JSON.stringify(body) : undefined,
    });
    const data = await res.json();
    if (!res.ok) throw new Error(data.message || 'Error');
    return data;
  };

  const register = async () => {
    const data = await api('/auth/register', 'POST', { name, email, password, role });
    setToken(data.token);
    localStorage.setItem('token', data.token);
    setMe(data.user);
  };

  const login = async () => {
    const data = await api('/auth/login', 'POST', { email, password });
    setToken(data.token);
    localStorage.setItem('token', data.token);
    setMe(data.user);
  };

  const getMe = async () => {
    const data = await api('/auth/me', 'GET');
    setMe(data);
  };

  const logout = async () => {
    await api('/auth/logout', 'POST');
    setToken('');
    localStorage.removeItem('token');
    setMe(null);
  };

  return (
    <div style={{ fontFamily: 'sans-serif', padding: 16 }}>
      <h2>Auth Demo (Sanctum)</h2>
      <div style={{ display: 'grid', gap: 8, maxWidth: 400 }}>
        <input placeholder="Name" value={name} onChange={e => setName(e.target.value)} />
        <input placeholder="Email" value={email} onChange={e => setEmail(e.target.value)} />
        <input placeholder="Password" type="password" value={password} onChange={e => setPassword(e.target.value)} />
        <select value={role} onChange={e => setRole(e.target.value)}>
          <option value="user">user</option>
          <option value="editor">editor</option>
          <option value="admin">admin</option>
        </select>
      </div>

      <div style={{ display: 'flex', gap: 8, marginTop: 12 }}>
        <button onClick={register}>Register</button>
        <button onClick={login}>Login</button>
        <button onClick={getMe} disabled={!token}>Me</button>
        <button onClick={logout} disabled={!token}>Logout</button>
      </div>

      <div style={{ marginTop: 16 }}>
        <div><strong>Token:</strong> {token ? token.slice(0, 24) + '...' : '(none)'}</div>
        <pre style={{ background: '#f5f5f5', padding: 12 }}>
          {me ? JSON.stringify(me, null, 2) : 'No me data'}
        </pre>
      </div>
    </div>
  );
}

const el = document.getElementById('react-root');
if (el) {
  const root = createRoot(el);
  root.render(<AuthDemo />);
}