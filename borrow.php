<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$videos = isset($_SESSION['videos']) ? $_SESSION['videos'] : [];

?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Available Videos</h3>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Director</th>
                    <th>Release Year</th>
                    <th>Casting Members</th>
                    <th>Genre</th>
                    <th>Description</th>
                    <th>Costs</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $videos = getBooks();
                if (count($videos) > 0) {
                    $availableVideos = array_filter($videos, function($video) {
                        return !isVideoRented($video['id']);
                    });

                    if (count($availableVideos) > 0) {
                        foreach ($availableVideos as $video) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($video['title']) . "</td>";
                            echo "<td>" . htmlspecialchars($video['director']) . "</td>";
                            echo "<td>" . htmlspecialchars($video['release_year']) . "</td>";
                            echo "<td>" . htmlspecialchars($video['casting_members']) . "</td>";
                            echo "<td>" . htmlspecialchars($video['genre']) . "</td>";
                            echo "<td>" . htmlspecialchars($video['description']) . "</td>";
                            echo "<td>$" . htmlspecialchars($video['cost']) . "</td>";
                            echo "<td>
                                <a href='index.php?page=renting&id={$video['id']}' class='btn btn-info'>Rent</a>
                                <a href='index.php?page=view_single&id={$video['id']}' class='btn btn-primary'>View Details</a>
                                </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8' class='text-center'>No videos available to rent</td></tr>";
                    }
                } else {
                    echo "<tr><td colspan='8' class='text-center'>No videos available</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
