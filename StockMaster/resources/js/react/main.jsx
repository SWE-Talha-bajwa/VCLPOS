import React from 'react';
import ReactDOM from 'react-dom/client';
import App from './App';

if (document.getElementById('react-app')) {
    const root = ReactDOM.createRoot(document.getElementById('react-app'));
    root.render(
        <React.StrictMode>
            <App />
        </React.StrictMode>
    );
}
