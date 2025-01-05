import React, { useEffect, useState } from 'react';
import { Progress } from 'antd';

const SeoScore = () => {
    const [score, setScore] = useState(0);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        // Gọi API để lấy điểm SEO
        fetch(ajaxurl + '?action=get_seo_score')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok ' + response.statusText);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    setScore(data.score); // Giả sử API trả về điểm số
                } else {
                    alert('Error loading SEO score: ' + data.data);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred: ' + error.message);
            })
            .finally(() => {
                setLoading(false);
            });
    }, []);

    return (
        <div>
            <h2>SEO Score</h2>
            {loading ? (
                <p>Loading...</p>
            ) : (
                <div>
                    <Progress percent={score} status={score >= 80 ? 'success' : 'exception'} />
                    <p>{score}/100</p>
                </div>
            )}
        </div>
    );
};

export default SeoScore;