import React, { useState } from 'react';
import API_ROUTES from '../config/api';
import GuestLayout from '../components/GuestLayout';

export default function Login() {
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const [remember, setRemember] = useState(false);
    const [errors, setErrors] = useState({});
    const [loading, setLoading] = useState(false);

    const handleSubmit = async (e) => {
        e.preventDefault();
        setLoading(true);
        setErrors({});

        try {
            const response = await fetch(API_ROUTES.LOGIN, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    email,
                    password,
                    remember
                }),
            });

            const data = await response.json();

            if (!response.ok) {
                // Handle validation errors
                if (data.errors) {
                    setErrors(data.errors);
                } else if (data.message) {
                    setErrors({ email: [data.message] });
                }
                setLoading(false);
                return;
            }

            // Store the token in localStorage
            localStorage.setItem('auth_token', data.token);
            localStorage.setItem('user', JSON.stringify(data.user));

            // Redirect to dashboard
            window.location.href = '/react/dashboard';

        } catch (error) {
            console.error('Login error:', error);
            setErrors({ email: ['An error occurred. Please try again.'] });
            setLoading(false);
        }
    };

    return (
        <GuestLayout>
            <form onSubmit={handleSubmit}>
                {/* Email Address */}
                <div>
                    <label htmlFor="email" className="block font-medium text-sm text-gray-700 dark:text-gray-300">
                        Email
                    </label>
                    <input
                        id="email"
                        type="email"
                        className="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full"
                        value={email}
                        onChange={(e) => setEmail(e.target.value)}
                        required
                        autoFocus
                        autoComplete="username"
                    />
                    {errors.email && (
                        <p className="text-sm text-red-600 dark:text-red-400 mt-2">{errors.email[0]}</p>
                    )}
                </div>

                {/* Password */}
                <div className="mt-4">
                    <label htmlFor="password" className="block font-medium text-sm text-gray-700 dark:text-gray-300">
                        Password
                    </label>
                    <input
                        id="password"
                        type="password"
                        className="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full"
                        value={password}
                        onChange={(e) => setPassword(e.target.value)}
                        required
                        autoComplete="current-password"
                    />
                    {errors.password && (
                        <p className="text-sm text-red-600 dark:text-red-400 mt-2">{errors.password[0]}</p>
                    )}
                </div>

                {/* Remember Me */}
                <div className="block mt-4">
                    <label htmlFor="remember_me" className="inline-flex items-center">
                        <input
                            id="remember_me"
                            type="checkbox"
                            className="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                            checked={remember}
                            onChange={(e) => setRemember(e.target.checked)}
                        />
                        <span className="ms-2 text-sm text-gray-600 dark:text-gray-400">Remember me</span>
                    </label>
                </div>

                <div className="flex items-center justify-end mt-4">
                    <a
                        href="/react/forgot-password"
                        className="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                    >
                        Forgot your password?
                    </a>

                    <button
                        type="submit"
                        disabled={loading}
                        className="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 ms-3 disabled:opacity-50"
                    >
                        {loading ? 'Logging in...' : 'Log in'}
                    </button>
                </div>

                {/* Register Link */}
                <div className="flex items-center justify-center mt-4">
                    <span className="text-sm text-gray-600 dark:text-gray-400">Don't have an account?</span>
                    <a
                        href="/react/register"
                        className="ms-2 underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                    >
                        Register
                    </a>
                </div>
            </form>
        </GuestLayout>
    );
}
