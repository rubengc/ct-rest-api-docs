<?php
/**
 * Table Rest API Docs
 */

global $ct_table;

// Shorthands
$singular = $ct_table->labels->singular_name;
$plural = $ct_table->labels->plural_name;
$controller = new CT_REST_Controller( $ct_table->name );
$rest_base = $ct_table->rest_base;
$schema = $controller->get_item_schema();
?>

<?php
// -------------------------
// Table of content
// --------------------------
?>
<div class="ct-rest-api-docs-table-of-contents">

    <h2>Table of contents</h2>

    <ul class="ct-rest-api-docs-items">

        <li><a href="#schema">Schema</a>
            <ul>
                <li><a href="#schema-example-request">Example Request</a></li>
            </ul>
        </li>

        <li><a href="#list-endpoint">List <?php echo $plural; ?></a>
            <ul>
                <li><a href="#list-arguments">Arguments</a></li>
                <li><a href="#list-definition">Definition</a></li>
                <li><a href="#list-example-request">Example Request</a></li>
            </ul>
        </li>

        <li><a href="#create-endpoint">Create a <?php echo $singular; ?></a>
            <ul>
                <li><a href="#create-arguments">Arguments</a></li>
                <li><a href="#create-definition">Definition</a></li>
                <li><a href="#create-example-request">Example Request</a></li>
            </ul>
        </li>

        <li><a href="#get-endpoint">Retrieve a <?php echo $singular; ?></a>
            <ul>
                <li><a href="#get-arguments">Arguments</a></li>
                <li><a href="#get-definition">Definition</a></li>
                <li><a href="#get-example-request">Example Request</a></li>
            </ul>
        </li>

        <li><a href="#update-endpoint">Update a <?php echo $singular; ?></a>
            <ul>
                <li><a href="#update-arguments">Arguments</a></li>
                <li><a href="#update-definition">Definition</a></li>
                <li><a href="#update-example-request">Example Request</a></li>
            </ul>
        </li>

        <li><a href="#delete-endpoint">Delete a <?php echo $singular; ?></a>
            <ul>
                <li><a href="#delete-arguments">Arguments</a></li>
                <li><a href="#delete-definition">Definition</a></li>
                <li><a href="#delete-example-request">Example Request</a></li>
            </ul>
        </li>

    </ul>

</div>

<?php
// -------------------------
// Schema
// --------------------------
?>

<section class="schema-section ct-rest-api-docs-section">

    <div class="primary">

        <h2 id="schema">Schema <a href="#schema"><span aria-hidden="true">#</span></a></h2>
        <p><?php printf( 'The schema defines all the fields that exist for a %s object.', strtolower( $singular ) ); ?></p>

        <table class="attributes">
            <tbody>

            <?php foreach( $schema['properties'] as $field => $field_args ) : ?>

                <tr id="schema-<?php echo $field; ?>">
                    <td>
                        <p class="field"><code><?php echo $field; ?></code></p>
                        <p class="type"><?php echo $field_args['type']; ?></p>
                    </td>
                    <td>
                        <p class="description"><?php echo $field_args['description']; ?></p>
                        <p class="context">Context: <?php echo '<code>' . implode('</code>, <code>', $field_args['context'] ) . '</code>'; ?></p>
                    </td>
                </tr>

            <?php endforeach; ?>

            </tbody>

        </table>

    </div>

    <div class="secondary">
        <h3 id="schema-example-request">Example Request <a href="#schema-example-request"><span aria-hidden="true">#</span></a></h3>
        <p><code>curl -X OPTIONS -i http://website.com/wp-json/wp/v2/<?php echo $rest_base; ?></code></p>
    </div>

</section>

<?php
// -------------------------
// List
// --------------------------
?>

<section class="list-section ct-rest-api-docs-section">

    <div class="primary">

        <h2 id="list-endpoint">List <?php echo $plural; ?> <a href="#list-endpoint"><span aria-hidden="true">#</span></a></h2>

        <h3 id="list-arguments">Arguments <a href="#list-arguments"><span aria-hidden="true">#</span></a></h3>

        <table class="arguments">

            <tbody>

                <?php foreach( $controller->get_collection_params() as $field => $field_args ) : ?>

                    <tr id="list-argument-<?php echo $field; ?>">
                        <td>
                            <p class="field"><code><?php echo $field; ?></code></p>
                        </td>
                        <td>
                            <p class="description"><?php echo $field_args['description']; ?></p>
                            <?php if( isset( $field_args['default'] ) && ! empty( $field_args['default'] ) ) : ?>
                                <p class="default">Default: <code><?php echo $field_args['default']; ?></code></p>
                            <?php endif; ?>
                            <?php if( isset( $field_args['enum'] ) ) : ?>
                                <p class="enum">One of: <?php echo str_replace( '<code></code>,', '', '<code>' . implode('</code>, <code>', $field_args['enum'] ) . '</code>' ); ?></p>
                            <?php endif; ?>
                        </td>
                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>

    </div>

    <div class="secondary">

        <h3 id="list-definition">Definition <a href="#list-definition"><span aria-hidden="true">#</span></a></h3>
        <p><code>GET /wp/v2/<?php echo $rest_base; ?></code></p>

        <h3 id="list-example-request">Example Request <a href="#list-example-request"><span aria-hidden="true">#</span></a></h3>
        <p><code>curl -X GET http://website.com/wp-json/wp/v2/<?php echo $rest_base; ?> -d "search=test&order=desc"</code></p>

    </div>

</section>

<?php
// -------------------------
// Create
// --------------------------
?>

<section class="create-section ct-rest-api-docs-section">

    <div class="primary">

        <h2 id="create-endpoint">Create a <?php echo $singular; ?> <a href="#create-endpoint"><span aria-hidden="true">#</span></a></h2>

        <h3 id="create-arguments">Arguments <a href="#create-arguments"><span aria-hidden="true">#</span></a></h3>

        <table class="arguments">
            <tbody>

                <?php foreach( $schema['properties'] as $field => $field_args ) :

                    // Skip id on create endpoint
                    if( $field === 'id' ) continue; ?>

                    <tr id="create-argument-<?php echo $field; ?>">
                        <td>
                            <p class="field"><code><a href="#schema-<?php echo $field; ?>"><?php echo $field; ?></a></code></p>
                        </td>
                        <td>
                            <p class="description"><?php echo $field_args['description']; ?></p>
                            <?php if( isset( $field_args['enum'] ) ) : ?>
                                <p class="enum">One of: <?php echo str_replace( '<code></code>,', '', '<code>' . implode('</code>, <code>', $field_args['enum'] ) . '</code>' ); ?></p>
                            <?php endif; ?>
                        </td>
                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>

    </div>

    <div class="secondary">

        <h3 id="create-definition">Definition <a href="#create-definition"><span aria-hidden="true">#</span></a></h3>
        <p><code>POST /wp/v2/<?php echo $rest_base; ?></code></p>

        <h3 id="create-example-request">Example Request <a href="#create-example-request"><span aria-hidden="true">#</span></a></h3>
        <p><code>curl -X POST http://website.com/wp-json/wp/v2/<?php echo $rest_base; ?> -d "title=test&user_id=1"</code></p>

    </div>

</section>

<?php
// -------------------------
// Get
// --------------------------
?>

<section class="get-section ct-rest-api-docs-section">

    <div class="primary">

        <h2 id="get-endpoint">Retrieve a <?php echo $singular; ?> <a href="#get-endpoint"><span aria-hidden="true">#</span></a></h2>

        <h3 id="get-arguments">Arguments <a href="#get-arguments"><span aria-hidden="true">#</span></a></h3>

        <table class="arguments">

            <tbody>

                <tr>
                    <td>
                        <code>id</code>
                    </td>
                    <td>
                        Unique identifier for the object.
                    </td>
                </tr>

                <tr>
                    <td>
                        <code>context</code>
                    </td>
                    <td>
                        <p class="description">Scope under which the request is made; determines fields present in response.</p>
                        <p class="default">Default: <code>view</code></p>
                        <p>One of: <code>view</code>, <code>embed</code>, <code>edit</code></p>
                    </td>
                </tr>

            </tbody>

        </table>

    </div>

    <div class="secondary">

        <h3 id="get-definition">Definition <a href="#get-definition"><span aria-hidden="true">#</span></a></h3>
        <p><code>GET /wp/v2/<?php echo $rest_base; ?>/&lt;id&gt;</code></p>

        <h3 id="get-example-request">Example Request <a href="#get-example-request"><span aria-hidden="true">#</span></a></h3>
        <p><code>curl -X GET http://demo.wp-api.org/wp-json/wp/v2/<?php echo $rest_base; ?>/&lt;id&gt;</code></p>
    </div>
</section>

<?php
// -------------------------
// Update
// --------------------------
?>

<section class="update-section ct-rest-api-docs-section">

    <div class="primary">

        <h2 id="update-endpoint">Update a <?php echo $singular; ?> <a href="#update-endpoint"><span aria-hidden="true">#</span></a></h2>

        <h3 id="update-arguments">Arguments <a href="#update-arguments"><span aria-hidden="true">#</span></a></h3>

        <table class="arguments">
            <tbody>

            <?php foreach( $schema['properties'] as $field => $field_args ) : ?>

                <tr id="update-argument-<?php echo $field; ?>">
                    <td>
                        <p class="field"><code><a href="#schema-<?php echo $field; ?>"><?php echo $field; ?></a></code></p>
                    </td>
                    <td>
                        <p class="description"><?php echo $field_args['description']; ?></p>
                        <?php if( isset( $field_args['enum'] ) ) : ?>
                            <p class="enum">One of: <?php echo str_replace( '<code></code>,', '', '<code>' . implode('</code>, <code>', $field_args['enum'] ) . '</code>' ); ?></p>
                        <?php endif; ?>
                    </td>
                </tr>

            <?php endforeach; ?>

            </tbody>

        </table>

    </div>

    <div class="secondary">

        <h3 id="update-definition">Definition <a href="#update-definition"><span aria-hidden="true">#</span></a></h3>
        <p><code>POST /wp/v2/<?php echo $rest_base; ?>/&lt;id&gt;</code></p>

        <h3 id="update-example-request">Example Request <a href="#update-example-request"><span aria-hidden="true">#</span></a></h3>
        <p><code>curl -X POST http://website.com/wp-json/wp/v2/<?php echo $rest_base; ?>/&lt;id&gt; -d "title=test&user_id=1"</code></p>

    </div>

</section>

<?php
// -------------------------
// Delete
// --------------------------
?>

<section class="delete-section ct-rest-api-docs-section">

    <div class="primary">

        <h2 id="delete-endpoint">Delete a <?php echo $singular; ?> <a href="#delete-endpoint"><span aria-hidden="true">#</span></a></h2>

        <h3 id="delete-arguments">Arguments <a href="#delete-arguments"><span aria-hidden="true">#</span></a></h3>

        <table class="arguments">

            <tbody>

                <tr>
                    <td>
                        <code>id</code>
                    </td>
                    <td>
                        Unique identifier for the object.
                    </td>
                </tr>

            </tbody>

        </table>

    </div>

    <div class="secondary">

        <h3 id="delete-definition">Definition <a href="#delete-definition"><span aria-hidden="true">#</span></a></h3>
        <p><code>DELETE /wp/v2/<?php echo $rest_base; ?>/&lt;id&gt;</code></p>

        <h3 id="delete-example-request">Example Request <a href="#delete-example-request"><span aria-hidden="true">#</span></a></h3>
        <p><code>curl -X DELETE http://demo.wp-api.org/wp-json/wp/v2/<?php echo $rest_base; ?>/&lt;id&gt;</code></p>
    </div>
</section>
