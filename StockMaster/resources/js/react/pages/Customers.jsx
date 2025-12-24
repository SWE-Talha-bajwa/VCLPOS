import React, { useState, useEffect } from 'react';

export default function Customers() {
    const [customers, setCustomers] = useState([]);
    const [loading, setLoading] = useState(true);

    const [showModal, setShowModal] = useState(false);
    const [editingCustomer, setEditingCustomer] = useState(null);
    const [formData, setFormData] = useState({
        name: '',
        email: '',
        phone: '',
        address: '',
        city: '',
        country: ''
    });
    const [errors, setErrors] = useState({});
    const [successMessage, setSuccessMessage] = useState('');
    const [pagination, setPagination] = useState({});

    useEffect(() => {
        fetchCustomers();
    }, []);

    const fetchCustomers = async (page = 1) => {
        try {
            const token = localStorage.getItem('auth_token');
            const response = await fetch(`/api/customers?page=${page}`, {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json',
                },
            });

            if (response.ok) {
                const data = await response.json();
                setCustomers(data.data);
                setPagination({
                    current_page: data.current_page,
                    last_page: data.last_page,
                    total: data.total
                });
            }
        } catch (error) {
            console.error('Error fetching customers:', error);
        } finally {
            setLoading(false);
        }
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        setErrors({});

        const token = localStorage.getItem('auth_token');
        const url = editingCustomer ? `/api/customers/${editingCustomer.id}` : '/api/customers';
        const method = editingCustomer ? 'PUT' : 'POST';

        try {
            const response = await fetch(url, {
                method: method,
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(formData)
            });

            const data = await response.json();

            if (response.ok) {
                setSuccessMessage(data.message);
                setShowModal(false);
                resetForm();
                fetchCustomers();
                setTimeout(() => setSuccessMessage(''), 3000);
            } else {
                setErrors(data.errors || {});
            }
        } catch (error) {
            console.error('Error saving customer:', error);
        }
    };

    const handleDelete = async (id) => {
        if (!confirm('Are you sure you want to delete this customer?')) return;

        const token = localStorage.getItem('auth_token');
        try {
            const response = await fetch(`/api/customers/${id}`, {
                method: 'DELETE',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json',
                },
            });

            if (response.ok) {
                const data = await response.json();
                setSuccessMessage(data.message);
                fetchCustomers();
                setTimeout(() => setSuccessMessage(''), 3000);
            }
        } catch (error) {
            console.error('Error deleting customer:', error);
        }
    };

    const openAddModal = () => {
        resetForm();
        setEditingCustomer(null);
        setShowModal(true);
    };

    const openEditModal = (customer) => {
        setEditingCustomer(customer);
        setFormData({
            name: customer.name,
            email: customer.email || '',
            phone: customer.phone,
            address: customer.address || '',
            city: customer.city || '',
            country: customer.country || ''
        });
        setShowModal(true);
    };

    const resetForm = () => {
        setFormData({
            name: '',
            email: '',
            phone: '',
            address: '',
            city: '',
            country: ''
        });
        setErrors({});
    };

    if (loading) {
        return (
            <main className="py-6 px-4 sm:px-6 lg:px-8">
                <div className="flex items-center justify-center h-64">
                    <div className="text-gray-500 animate-pulse">Loading Customers...</div>
                </div>
            </main>
        );
    }

    return (
        <>
            <main className="py-6 px-4 sm:px-6 lg:px-8">
                <div className="bg-white dark:bg-gray-800 rounded-lg shadow">
                    <div className="p-6">
                        {/* Header with Add Button */}
                        <div className="flex justify-between items-center mb-6">
                            <h2 className="text-2xl font-semibold text-gray-900 dark:text-white">Customer List</h2>
                            <button
                                onClick={openAddModal}
                                className="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700"
                            >
                                Add Customer
                            </button>
                        </div>

                        {/* Success Message */}
                        {successMessage && (
                            <div className="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                                {successMessage}
                            </div>
                        )}

                        {/* Customers Table */}
                        <div className="overflow-x-auto">
                            <table className="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead className="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
                                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Phone</th>
                                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Email</th>
                                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">City</th>
                                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody className="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    {customers.length > 0 ? (
                                        customers.map((customer) => (
                                            <tr key={customer.id}>
                                                <td className="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                                    {customer.name}
                                                </td>
                                                <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                    {customer.phone}
                                                </td>
                                                <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                    {customer.email || 'N/A'}
                                                </td>
                                                <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                    {customer.city || 'N/A'}
                                                </td>
                                                <td className="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    <button
                                                        onClick={() => openEditModal(customer)}
                                                        className="text-indigo-600 hover:text-indigo-900 mr-3"
                                                    >
                                                        Edit
                                                    </button>
                                                    <button
                                                        onClick={() => handleDelete(customer.id)}
                                                        className="text-red-600 hover:text-red-900"
                                                    >
                                                        Delete
                                                    </button>
                                                </td>
                                            </tr>
                                        ))
                                    ) : (
                                        <tr>
                                            <td colSpan="5" className="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                                No customers found.
                                            </td>
                                        </tr>
                                    )}
                                </tbody>
                            </table>
                        </div>

                        {/* Pagination */}
                        {pagination.last_page > 1 && (
                            <div className="mt-4 flex justify-between items-center">
                                <div className="text-sm text-gray-700 dark:text-gray-300">
                                    Showing page {pagination.current_page} of {pagination.last_page}
                                </div>
                                <div className="flex space-x-2">
                                    <button
                                        onClick={() => fetchCustomers(pagination.current_page - 1)}
                                        disabled={pagination.current_page === 1}
                                        className="px-3 py-1 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded disabled:opacity-50"
                                    >
                                        Previous
                                    </button>
                                    <button
                                        onClick={() => fetchCustomers(pagination.current_page + 1)}
                                        disabled={pagination.current_page === pagination.last_page}
                                        className="px-3 py-1 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded disabled:opacity-50"
                                    >
                                        Next
                                    </button>
                                </div>
                            </div>
                        )}
                    </div>
                </div>
            </main>

            {/* Add/Edit Modal */}
            {showModal && (
                <div className="fixed inset-0 z-50 overflow-y-auto">
                    <div className="flex items-center justify-center min-h-screen px-4">
                        <div className="fixed inset-0 bg-gray-500 bg-opacity-75" onClick={() => setShowModal(false)}></div>

                        <div className="relative bg-white dark:bg-gray-800 rounded-lg max-w-2xl w-full p-6">
                            <h3 className="text-lg font-medium text-gray-900 dark:text-white mb-4">
                                {editingCustomer ? 'Edit Customer' : 'Add Customer'}
                            </h3>

                            <form onSubmit={handleSubmit}>
                                <div className="grid grid-cols-2 gap-4">
                                    <div>
                                        <label className="block text-sm font-medium text-gray-700 dark:text-gray-300">Name *</label>
                                        <input
                                            type="text"
                                            value={formData.name}
                                            onChange={(e) => setFormData({ ...formData, name: e.target.value })}
                                            className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                        />
                                        {errors.name && <p className="text-red-500 text-xs mt-1">{errors.name[0]}</p>}
                                    </div>

                                    <div>
                                        <label className="block text-sm font-medium text-gray-700 dark:text-gray-300">Phone *</label>
                                        <input
                                            type="text"
                                            value={formData.phone}
                                            onChange={(e) => setFormData({ ...formData, phone: e.target.value })}
                                            className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                        />
                                        {errors.phone && <p className="text-red-500 text-xs mt-1">{errors.phone[0]}</p>}
                                    </div>

                                    <div className="col-span-2">
                                        <label className="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                                        <input
                                            type="email"
                                            value={formData.email}
                                            onChange={(e) => setFormData({ ...formData, email: e.target.value })}
                                            className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                        />
                                        {errors.email && <p className="text-red-500 text-xs mt-1">{errors.email[0]}</p>}
                                    </div>

                                    <div className="col-span-2">
                                        <label className="block text-sm font-medium text-gray-700 dark:text-gray-300">Address</label>
                                        <input
                                            type="text"
                                            value={formData.address}
                                            onChange={(e) => setFormData({ ...formData, address: e.target.value })}
                                            className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                        />
                                    </div>

                                    <div>
                                        <label className="block text-sm font-medium text-gray-700 dark:text-gray-300">City</label>
                                        <input
                                            type="text"
                                            value={formData.city}
                                            onChange={(e) => setFormData({ ...formData, city: e.target.value })}
                                            className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                        />
                                    </div>

                                    <div>
                                        <label className="block text-sm font-medium text-gray-700 dark:text-gray-300">Country</label>
                                        <input
                                            type="text"
                                            value={formData.country}
                                            onChange={(e) => setFormData({ ...formData, country: e.target.value })}
                                            className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                        />
                                    </div>
                                </div>

                                <div className="mt-6 flex justify-end space-x-3">
                                    <button
                                        type="button"
                                        onClick={() => setShowModal(false)}
                                        className="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300"
                                    >
                                        Cancel
                                    </button>
                                    <button
                                        type="submit"
                                        className="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700"
                                    >
                                        {editingCustomer ? 'Update' : 'Create'}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            )}
        </>
    );
}
