import React, { useState, useEffect } from 'react';
// Imports removed

export default function ProfilePage() {
    // isOpen state removed
    const [user, setUser] = useState({
        name: '',
        email: '',
    });
    const [passwords, setPasswords] = useState({
        current_password: '',
        new_password: '',
        new_password_confirmation: ''
    });
    const [loading, setLoading] = useState(false);
    const [message, setMessage] = useState({ type: '', text: '' });

    useEffect(() => {
        const storedUser = JSON.parse(localStorage.getItem('user') || '{}');
        setUser({
            name: storedUser.name || '',
            email: storedUser.email || '',
        });
    }, []);

    const handleProfileUpdate = async (e) => {
        e.preventDefault();
        setLoading(true);
        setMessage({ type: '', text: '' });

        try {
            const token = localStorage.getItem('auth_token');
            const response = await fetch('/api/profile', {
                method: 'PUT',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    name: user.name,
                    email: user.email,
                })
            });

            const data = await response.json();

            if (response.ok) {
                setMessage({ type: 'success', text: 'Profile updated successfully!' });
                const storedUser = JSON.parse(localStorage.getItem('user') || '{}');
                localStorage.setItem('user', JSON.stringify({ ...storedUser, name: user.name, email: user.email }));
            } else {
                setMessage({ type: 'error', text: data.message || 'Failed to update profile.' });
            }
        } catch (error) {
            console.error(error);
            setMessage({ type: 'error', text: 'An unexpected error occurred.' });
        } finally {
            setLoading(false);
        }
    };

    const handlePasswordUpdate = async (e) => {
        e.preventDefault();
        setLoading(true);
        setMessage({ type: '', text: '' });

        if (passwords.new_password !== passwords.new_password_confirmation) {
            setMessage({ type: 'error', text: 'New passwords do not match.' });
            setLoading(false);
            return;
        }

        try {
            const token = localStorage.getItem('auth_token');
            const response = await fetch('/api/profile/password', {
                method: 'PUT',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(passwords)
            });

            const data = await response.json();

            if (response.ok) {
                setMessage({ type: 'success', text: 'Password updated successfully!' });
                setPasswords({ current_password: '', new_password: '', new_password_confirmation: '' });
            } else {
                setMessage({ type: 'error', text: data.message || 'Failed to update password.' });
            }
        } catch (error) {
            console.error(error);
            setMessage({ type: 'error', text: 'An unexpected error occurred.' });
        } finally {
            setLoading(false);
        }
    };

    return (
        <main className="p-6 max-w-4xl mx-auto">
            {message.text && (
                <div className={`mb-6 p-4 rounded-lg border ${message.type === 'success' ? 'bg-green-100 border-green-400 text-green-700' : 'bg-red-100 border-red-400 text-red-700'}`}>
                    {message.text}
                </div>
            )}

            <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div className="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <h2 className="text-lg font-medium text-gray-900 dark:text-white mb-4">Profile Information</h2>
                    <form onSubmit={handleProfileUpdate} className="space-y-4">
                        <div>
                            <label className="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                            <input
                                type="text"
                                value={user.name}
                                onChange={(e) => setUser({ ...user, name: e.target.value })}
                                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm p-2 border"
                                required
                            />
                        </div>
                        <div>
                            <label className="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                            <input
                                type="email"
                                value={user.email}
                                onChange={(e) => setUser({ ...user, email: e.target.value })}
                                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm p-2 border"
                                required
                            />
                        </div>
                        <div className="pt-2">
                            <button
                                type="submit"
                                disabled={loading}
                                className="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 disabled:opacity-50"
                            >
                                Save Profile
                            </button>
                        </div>
                    </form>
                </div>

                <div className="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <h2 className="text-lg font-medium text-gray-900 dark:text-white mb-4">Update Password</h2>
                    <form onSubmit={handlePasswordUpdate} className="space-y-4">
                        <div>
                            <label className="block text-sm font-medium text-gray-700 dark:text-gray-300">Current Password</label>
                            <input
                                type="password"
                                value={passwords.current_password}
                                onChange={(e) => setPasswords({ ...passwords, current_password: e.target.value })}
                                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm p-2 border"
                                required
                            />
                        </div>
                        <div>
                            <label className="block text-sm font-medium text-gray-700 dark:text-gray-300">New Password</label>
                            <input
                                type="password"
                                value={passwords.new_password}
                                onChange={(e) => setPasswords({ ...passwords, new_password: e.target.value })}
                                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm p-2 border"
                                required
                            />
                        </div>
                        <div>
                            <label className="block text-sm font-medium text-gray-700 dark:text-gray-300">Confirm Password</label>
                            <input
                                type="password"
                                value={passwords.new_password_confirmation}
                                onChange={(e) => setPasswords({ ...passwords, new_password_confirmation: e.target.value })}
                                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm p-2 border"
                                required
                            />
                        </div>
                        <div className="pt-2">
                            <button
                                type="submit"
                                disabled={loading}
                                className="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gray-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 disabled:opacity-50"
                            >
                                Update Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    );
}
