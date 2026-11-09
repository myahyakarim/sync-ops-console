import { useEffect, useState } from 'react';
import './App.css';

type SyncJob = {
  id: number;
  reference: string;
  job_type: string;
  status: string;
  attempts: number;
  last_error: string | null;
  created_at: string;
};

const API = import.meta.env.VITE_API_URL ?? 'http://127.0.0.1:8000/api';

export default function App() {
  const [jobs, setJobs] = useState<SyncJob[]>([]);
  const [filter, setFilter] = useState('');
  const [error, setError] = useState<string | null>(null);

  async function load() {
    try {
      const qs = filter ? `?status=${encodeURIComponent(filter)}` : '';
      const res = await fetch(`${API}/jobs${qs}`);
      if (!res.ok) throw new Error(`HTTP ${res.status}`);
      const json = await res.json();
      setJobs(json.data);
      setError(null);
    } catch {
      setError('Cannot reach Laravel API. Run `php artisan serve` in the project root.');
    }
  }

  useEffect(() => {
    void load();
  }, [filter]);

  async function requeue(id: number) {
    await fetch(`${API}/jobs/${id}/requeue`, { method: 'POST' });
    await load();
  }

  return (
    <div className="page">
      <header>
        <p className="eyebrow">LedgerBridge Ops</p>
        <h1>Sync Ops Console</h1>
        <p className="lede">Monitor async sync jobs — requeue failed work safely.</p>
      </header>

      <div className="toolbar">
        <label>
          Status
          <select value={filter} onChange={(e) => setFilter(e.target.value)}>
            <option value="">All</option>
            <option value="queued">queued</option>
            <option value="running">running</option>
            <option value="succeeded">succeeded</option>
            <option value="failed">failed</option>
          </select>
        </label>
        <button type="button" onClick={() => void load()}>Refresh</button>
      </div>

      {error && <p className="error">{error}</p>}

      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Reference</th>
            <th>Type</th>
            <th>Status</th>
            <th>Attempts</th>
            <th>Error</th>
            <th />
          </tr>
        </thead>
        <tbody>
          {jobs.map((job) => (
            <tr key={job.id}>
              <td>{job.id}</td>
              <td>{job.reference}</td>
              <td>{job.job_type}</td>
              <td><span className={`status ${job.status}`}>{job.status}</span></td>
              <td>{job.attempts}</td>
              <td className="err">{job.last_error ?? '—'}</td>
              <td>
                {job.status === 'failed' && (
                  <button type="button" onClick={() => void requeue(job.id)}>Requeue</button>
                )}
              </td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
}
