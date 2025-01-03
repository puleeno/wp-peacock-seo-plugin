import React, { useEffect, useState } from 'react';
import ReactDOM from 'react-dom';
import { Button, Input, Form } from 'antd';
import 'antd/dist/antd.css';

const App = () => {
    const [form] = Form.useForm();
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        // Gọi API để tải dữ liệu từ cơ sở dữ liệu
        fetch(ajaxurl + '?action=load_peacock_options')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok ' + response.statusText);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Cập nhật giá trị vào form
                    form.setFieldsValue(data.data);
                } else {
                    alert('Error loading options: ' + data.data);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred: ' + error.message);
            })
            .finally(() => {
                setLoading(false);
            });
    }, [form]);

    const onFinish = (values) => {
        console.log('Received values:', values);

        // Gửi dữ liệu đến server để lưu
        fetch(ajaxurl + '?action=save_peacock_options', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                options: values,
            }),
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                alert('Options saved successfully!');
            } else {
                alert('Error saving options: ' + data.data);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred: ' + error.message);
        });
    };

    return (
        <div style={{ padding: '20px' }}>
            <h1>Peacock SEO Options</h1>
            {loading ? (
                <p>Loading...</p>
            ) : (
                <Form form={form} onFinish={onFinish}>
                    <Form.Item
                        label="Option 1"
                        name="option_1"
                        rules={[{ required: true, message: 'Please input your option 1!' }]}
                    >
                        <Input />
                    </Form.Item>
                    <Form.Item
                        label="Option 2"
                        name="option_2"
                        rules={[{ required: true, message: 'Please input your option 2!' }]}
                    >
                        <Input />
                    </Form.Item>
                    <Form.Item>
                        <Button type="primary" htmlType="submit">
                            Submit
                        </Button>
                    </Form.Item>
                </Form>
            )}
        </div>
    );
};

ReactDOM.render(<App />, document.getElementById('peacock-seo-app'));